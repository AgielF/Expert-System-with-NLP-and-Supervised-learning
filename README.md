# Fuzzy Expert System with NLP Chatbot 🧠🤖

![Project Banner](https://via.placeholder.com/1000x300.png?text=Fuzzy+Expert+System+&+NLP+Chatbot)

This project is a web-based expert system that leverages **fuzzy logic** for complex decision-making. It features a conversational interface powered by a **Natural Language Processing (NLP)** chatbot, built with Python and Supervised Learning, and served via a Flask API.

The core application is built with **Laravel**, which provides the user interface and the expert system logic, while consuming the Python chatbot model for intelligent, human-like interaction.

---

## 🚀 Core Features

* **Fuzzy Expert System:** Implements fuzzy logic rules to handle uncertainty and provide nuanced recommendations or diagnoses.
* **NLP Chatbot:** A supervised learning model trained to understand user queries and provide relevant responses.
* **Decoupled Architecture:** The user-facing expert system (Laravel) is separate from the AI model (Python/Flask), allowing for independent development and scaling.
* **API Integration:** The Laravel backend communicates with the chatbot model through a clean REST API.
* **Interactive UI:** A simple and effective chat interface for users to interact with the expert system.

---

## 🏛️ System Architecture

The project is divided into two main components that run independently but communicate with each other.


1.  **Laravel Expert System:** Handles user authentication, the main web interface, and the core fuzzy logic calculations.
2.  **FAST API AI Service:** A lightweight Python server that wraps the trained NLP model and exposes it through an API endpoint.

---

## 🛠️ Tech Stack

* **Expert System Backend:**
    * [**Laravel**](https://laravel.com/) (PHP Framework)
    * [**PHP**](https://www.php.net/)
    * **Composer** for package management
* **AI / Chatbot Backend:**
    * [**Python**](https.python.org/)
    * [**Flask**](https://flask.palletsprojects.com/) for serving the API
    * [**scikit-learn**](https://scikit-learn.org/), [**pandas**](https://pandas.pydata.org/), [**NLTK**](https://www.nltk.org/) (or other relevant NLP/ML libraries)
* **Database:**
    * MySQL or PostgreSQL
* **Frontend:**
    * Blade Templates
    * Vite (for asset bundling)
    * JavaScript, CSS

---

## ⚙️ Installation & Setup

You need to set up and run **both** the Laravel application and the Flask API service.

### Part 1: AI Chatbot API (Flask)

First, set up the Python environment that serves your trained model.

1.  **Navigate to the AI directory:**
    ```bash
    cd API_CHATBOT/
    ```
2.  **Create and activate a virtual environment:**
    ```bash
    python -m venv venv
    source venv/bin/activate  # On Windows: venv\Scripts\activate
    ```
3.  **Install Python dependencies:**
    ```bash
    pip install -r requirements.txt
    ```
4.  **Run the FASTAPI server:**
    ```bash
    uvicorn main:app --reload
    ```

### Part 2: Expert System (Laravel)

Next, set up the main Laravel application.

1.  **Navigate to the expert system directory:**
    ```bash
    cd Expert-Ginjal-master
    ```
2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```
3.  **Install frontend dependencies:**
    ```bash
    npm install
    ```
4.  **Create your environment file:**
    ```bash
    cp .env.example .env
    ```
5.  **Configure your `.env` file:**
    * Set up your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
    * **Crucially, point to your running Flask API:**
        ```env
        CHATBOT_API_URL=[http://127.0.0.1:5000](http://127.0.0.1:5000)
        ```
6.  **Build frontend assets:**
    ```bash
    npm run dev
    ```
7.  **Run the Laravel development server:**
    ```bash
    php artisan serve
    ```
    Your expert system is now available at `http://127.0.0.1:8000`.

---

## ▶️ Usage

1.  Ensure both the **Fast API** and the **Laravel** servers are running.
2.  Open your web browser and go to `http://127.0.0.1:8000`.
3.  Navigate to the chat interface and start a conversation. Your input will be sent to the Laravel backend, which then calls the Flask API to get a response from the NLP model.

---



## 🤝 Contributing

Contributions are welcome! Please feel free to fork the repository, make changes, and submit a pull request. For major changes, please open an issue first to discuss what you would like to change.

---

## 📜 License

This project is licensed under the **MIT License**. See the `LICENSE.md` file for details.
