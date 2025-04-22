let apiKey = localStorage.getItem('api_key') || ""; 

function register() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (username && email && password) {
        fetch('http://localhost:8000/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: username,
                email: email,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('register-section').style.display = 'none';
                document.getElementById('login-section').style.display = 'block';
                alert('Registration successful! Please log in.');
            } else {
                alert('Registration failed!');
            }
        })
        .catch(error => alert('An error occurred during registration.'));
    } else {
        alert('Please fill all fields.');
    }
}

function login() {
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    if (username && password) {
        fetch('http://localhost:8000/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: username,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                apiKey = data.data.api_key;
                localStorage.setItem('api_key', apiKey); 

                document.getElementById('login-section').style.display = 'none';
                document.getElementById('weather-skincare-section').style.display = 'block';
                document.getElementById('api-key-value').innerText = apiKey;
                document.getElementById('user-info').innerText = `Welcome, ${data.data.name}`;
            } else {
                alert('Invalid credentials.');
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred during login.');
        });
    } else {
        alert('Please enter valid credentials.');
    }
}

function getWeatherData() {
    const city = document.getElementById('city').value;
    const storedApiKey = localStorage.getItem('api_key');

    if (city && storedApiKey) {

        const openWeatherKey = '7b99b27411e8abaa988942289e790319';

        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${openWeatherKey}&units=metric`)
            .then(response => response.json())
            .then(data => {
                if (data.cod === 200) {  
                    const description = data.weather[0].description;
                    localStorage.setItem('weatherDescription', description); 
                    document.getElementById('weather-result').innerHTML = `
                        <strong>Weather in ${city}:</strong><br>
                        Temperature: ${data.main.temp}°C<br>
                        Weather: ${description}
                    `;
                } else {
                    document.getElementById('weather-result').innerHTML = `City not found! Please try again.`;
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error fetching weather data. Please check your connection or the city name.");
            });
    } else {
        alert("Please enter a city and ensure you are logged in.");
    }
}

function getSkincareRecommendations() {
    const weatherDescription = localStorage.getItem('weatherDescription');

    if (weatherDescription) {
        const weatherCategory = mapWeatherToCategory(weatherDescription);

        const allProducts = [
            { name: "SunShield SPF 50", type: "sunscreen" },
            { name: "Aqua Boost Gel", type: "hydrating" },
            { name: "Rainy Calm Serum", type: "calming" },
            { name: "Winter Moist Balm", type: "moisturizing" },
            { name: "Barrier Repair Cream", type: "barrier-repair" },
            { name: "Cloud Dew Mist", type: "hydrating" },
            { name: "Soothing Thunder Essence", type: "calming" }
        ];

        let filteredProducts;

        switch (weatherCategory) {
            case "clear":
                filteredProducts = allProducts.filter(p => p.type === 'sunscreen');
                break;
            case "cloudy":
                filteredProducts = allProducts.filter(p => p.type === 'hydrating');
                break;
            case "rain":
                filteredProducts = allProducts.filter(p => p.type === 'hydrating' || p.type === 'calming');
                break;
            case "snow":
                filteredProducts = allProducts.filter(p => p.type === 'moisturizing');
                break;
            case "thunderstorm":
                filteredProducts = allProducts.filter(p => p.type === 'calming');
                break;
            case "mist":
                filteredProducts = allProducts.filter(p => p.type === 'hydrating');
                break;
            case "extreme":
                filteredProducts = allProducts.filter(p => p.type === 'barrier-repair');
                break;
            default:
                filteredProducts = allProducts.slice(0, 3); 
        }

        document.getElementById('skincare-result').innerHTML = `
            <strong>Skincare recommendations based on current weather:</strong><br>
            <ul>
                ${filteredProducts.map(product => `<li>${product.name}</li>`).join('')}
            </ul>
        `;
    } else {
        alert("Weather data not found. Please check your weather API.");
    }
}

function mapWeatherToCategory(description) {
    const desc = description.toLowerCase();

    if (desc.includes("clear")) return "clear";
    if (desc.includes("cloud")) return "cloudy";
    if (desc.includes("rain")) return "rain";
    if (desc.includes("snow")) return "snow";
    if (desc.includes("thunderstorm")) return "thunderstorm";
    if (desc.includes("mist") || desc.includes("fog") || desc.includes("haze")) return "mist";
    if (desc.includes("extreme") || desc.includes("tornado") || desc.includes("hail")) return "extreme";

    return "unknown";
}
