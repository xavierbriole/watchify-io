$("#registerForm").validate({
  rules: {
    username: {
      required: true,
      minlength: 2
    },
    name: {
      required: true,
      minlength: 2
    },
    choose_password: {
      required: true,
      minlength: 6
    },
    password_again: {
      required: true,
      minlength: 6,
      equalTo: "#choose_password"
    },
    email: {
      required: true,
      email: true
    }
  }
});

$("#registerForm").validate({
  errorClass: "invalid",
  validClass: "valid",
  errorPlacement: function (error, element) {
  $(element)
    .closest("registerForm")
    .find("label[for='" + element.attr("id") + "']")
    .attr('data-error', error.text());
  },
  submitHandler: function (form) {
    next();
  }
});