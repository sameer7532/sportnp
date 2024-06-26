const rules = {
  fullname: {
    required: true,
    pattern: /^[a-zA-Z\s]*$/,
    minLength: 3,
    maxLength: 50,
    errorMessage: 'Fullname is required and should be between 3 to 50 characters'
  },
  email: {
    required: true,
    pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    errorMessage: 'Please enter a valid email'
  },
  phone: {
    required: true,
    pattern: /^\d{10}$/,
    errorMessage: 'Please enter a valid phone number'
  },
  password: {
    required: true,
    minLength: 8,
    maxLength: 20,
    errorMessage: 'Password is required and should be between 8 to 20 characters'
  },
  confirmPassword: {
    required: true,
    errorMessage: 'Please confirm the password',
    validate: (value, elements) => {
      const password = elements.password.value;
      return value === password;
    }
  },
  title: {
    required: true,
    minLength: 3,
    maxLength: 50,
    errorMessage: 'Title is required and should be between 3 to 50 characters'
  },
  price: {
    required: true,
    pattern: /^\d+(\.\d{1,2})?$/,
    errorMessage: 'Please enter a valid price'
  },
  image: {
    required: true,
    errorMessage: 'Please select an image less than 2MB',
    validate: (value, elements) => {
      const fileInput = elements.image;
      const file = fileInput.files[0];
      if (!file) {
        return false;
      }
      const validExtensions = ['image/jpeg', 'image/png', 'image/gif'];
      const maxSize = 2 * 1024 * 1024; // 2MB
      return validExtensions.includes(file.type) && file.size <= maxSize;
    }
  },
};

const forms = [
  'registerForm', 
  'loginForm',
  'product-form',
];

forms.forEach(form => {
  const formElement = document.getElementById(form);
  formElement?.addEventListener('submit', event => validateForm(event));
});

function validateForm(event) {
  event.preventDefault();
  const elements = Array.from(event.target.querySelectorAll('input, textarea'));
  let allValid = true;

  elements.forEach(input => {
    if (!validateInput(input)) {
      allValid = false;
    }
  });

  if (allValid) {
    event.target.submit();
  }
}

function validateInput(input) {
  const { name, value, type } = input;
  const rule = rules[name];

  if (!rule) return true; 

  if (rule.required && !value) {
    showError(input, rule.errorMessage);
    return false;
  }

  if (rule.pattern && !rule.pattern.test(value)) {
    showError(input, rule.errorMessage);
    return false;
  }

  if (rule.minLength && value.length < rule.minLength) {
    showError(input, rule.errorMessage);
    return false;
  }

  if (rule.maxLength && value.length > rule.maxLength) {
    showError(input, rule.errorMessage);
    return false;
  }

  if (rule.validate && !rule.validate(value, input.form.elements)) {
    showError(input, rule.errorMessage);
    return false;
  }

  if (type === 'file' && input.files.length > 0) {
    const file = input.files[0];
    const validExtensions = ['image/jpeg', 'image/png', 'image/gif'];
    const maxSize = 2 * 1024 * 1024; // 2MB
    if (!validExtensions.includes(file.type) || file.size > maxSize) {
      showError(input, rule.errorMessage || 'Invalid file type or size');
      return false;
    }
  }

  hideError(input);
  return true;
}

function showError(input, message) {
  hideError(input); 
  const error = document.createElement('span');
  error.className = 'error';
  error.innerHTML = message;
  error.style.color = 'red';
  error.style.fontSize = '12px';

  input.parentNode.insertBefore(error, input.nextSibling);
}

function hideError(input) {
  const error = input.parentNode.querySelector('.error');
  if (error) {
    error.remove();
  }
}
