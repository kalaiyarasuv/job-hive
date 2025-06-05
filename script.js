function validateForm() {
  const name = document.getElementById('name').value.trim();
  const jobInterests = document.getElementById('job_interests').value.trim();
  const gender = document.getElementById('gender').value;
  const dob = document.getElementById('dob').value;
  const address = document.getElementById('address').value.trim();
  const imageInput = document.getElementById('image');

  // Name validation (letters and spaces only)
  if (!name.match(/^[A-Za-z\s]+$/)) {
    alert("Please enter a valid full name (letters and spaces only).");
    return false;
  }

  // Job Interests validation
  if (jobInterests === "") {
    alert("Please enter your job interests.");
    return false;
  }

  // Gender validation
  if (gender === "") {
    alert("Please select your gender.");
    return false;
  }

  // DOB validation - check if user is at least 18 years old
  if (dob === "") {
    alert("Please enter your date of birth.");
    return false;
  }
  const dobDate = new Date(dob);
  const today = new Date();
  const age = today.getFullYear() - dobDate.getFullYear();
  const monthDiff = today.getMonth() - dobDate.getMonth();
  if (
    age < 18 ||
    (age === 18 && monthDiff < 0) ||
    (age === 18 && monthDiff === 0 && today.getDate() < dobDate.getDate())
  ) {
    alert("You must be at least 18 years old.");
    return false;
  }

  // Address validation
  if (address === "") {
    alert("Please enter your address.");
    return false;
  }

  // Image validation
  if (imageInput.files.length === 0) {
    alert("Please upload an image.");
    return false;
  } else {
    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    const fileName = imageInput.value;
    if (!allowedExtensions.exec(fileName)) {
      alert("Please upload file having extensions .jpeg/.jpg/.png/.gif only.");
      imageInput.value = "";
      return false;
    }
  }

  return true; // All validations passed
}
