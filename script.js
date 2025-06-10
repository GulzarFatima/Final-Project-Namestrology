document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("nameForm");
    const input = document.getElementById("nameInput");
    const result = document.getElementById("result");
    const emojiContainer = document.getElementById("emoji-bg");
  
    form.addEventListener("submit", async function (event) {

      event.preventDefault();
  
      const name = input.value.trim();

      // validation - empty name field
      if (!name) {
        result.textContent = "Please enter a name.";
        return;
      }

      result.textContent = "✨ Consulting the stars...";
  
      try {
        // send POST request with JSON to api.php
        const response = await fetch("api.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ name: name }),
        });

        //parse JSON result from PHP
        const data = await response.json();
        // show response else fallback for 'missing/ bad response'
        result.textContent = data.result || "Something went wrong.";
      } // API failure/ server down/ network lost faalback
        catch (error) {
        result.textContent = "Error talking to the stars!";
      }

    });
  
    // floating emoji background setup

    // emoji list array
    const emojiList = ["🔮", "👹", "🌌", "💀", "🧿", "🪐", "👽", "♓", "✨", "😈", "🤡"];
   
    // loop that goes through each emoji in the emojiList array
    for (let i = 0; i < emojiList.length; i++) {
      // create a span element for each emoj
      const span = document.createElement("span");
      // define emoji behavior from style.css
      span.classList.add("emoji");
      // text content to emoji
      span.textContent = emojiList[i];
      // set random position and animation properties
      span.style.left = `${Math.random() * 100}vw`;
      // placement below bottom of the screen - float up
      span.style.bottom = `-50px`;
      // random delay and duration for the animation
      span.style.animationDelay = `${Math.random() * 10}s`;
      // randome animation duration between 15 and 25 seconds
      span.style.animationDuration = `${15 + Math.random() * 10}s`;
      //place it into the page so it can appear
      emojiContainer.appendChild(span);
    }
  });
  