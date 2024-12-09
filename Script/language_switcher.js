document.addEventListener("DOMContentLoaded", function () {
    const languageSelector = document.getElementById("language-selector");
    const supportedLanguages = ["en", "de"];
    const defaultLanguage = "en";

    // Function to translate the page based on the selected language
    function translatePage(lang) {
        document.querySelectorAll("[data-lang]").forEach(element => {
            // Show elements matching the selected language
            if (element.getAttribute("data-lang") === lang) {
                element.style.display = "";
            } else {
                element.style.display = "none";
            }
        });
    }

    // Function to set the language and save preference
    function setLanguage(lang) {
        if (!supportedLanguages.includes(lang)) lang = defaultLanguage;
        localStorage.setItem("preferredLanguage", lang);
        translatePage(lang);
    }

    // Event listener for language selector
    languageSelector.addEventListener("change", function () {
        setLanguage(this.value);
    });

    // Load the preferred language from local storage or use the default
    const storedLanguage = localStorage.getItem("preferredLanguage") || defaultLanguage;
    languageSelector.value = storedLanguage;
    setLanguage(storedLanguage);
});
