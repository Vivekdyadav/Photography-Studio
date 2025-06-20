// Assuming your login validation is successful:
localStorage.setItem("isLoggedIn", "true");

// Check if user clicked 'My Booking' and was redirected to login
if (localStorage.getItem("redirectToBooking") === "true") {
  localStorage.removeItem("redirectToBooking");
  window.location.href = "book.html";
} else {
  window.location.href = "indexx.html"; // default page
}

const showHidePasswords = (idPrefix) => {
  const passwordButton = document.getElementById(`${idPrefix}-eye`);
  if (!passwordButton) return;

  passwordButton.addEventListener("click", () => {
    const passwordInput = document.getElementById(idPrefix);
    const icon = passwordButton.querySelector("i");

    const isVisible = icon.classList.contains("ri-eye-fill");
    passwordInput.type = isVisible ? "password" : "text";
    icon.className = isVisible ? "ri-eye-off-fill" : "ri-eye-fill";
  });
};

// Apply to all password fields
showHidePasswords("login-password");
showHidePasswords("signup-password");
showHidePasswords("confirm-password");
