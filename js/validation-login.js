$("#loginForm").validate({
  rules: {
    username: {
      required: true,
      minlength: 1
    },
    password: {
      required: true,
      minlength: 1
    }
  }
});

$("#loginForm").validate({
  errorClass: "invalid",
  validClass: "valid",
  errorPlacement: function (error, element) {
  $(element)
    .closest("#loginForm")
    .find("label[for='" + element.attr("id") + "']")
    .attr('data-error', error.text());
    console.log("label[for='" + element.attr("id") + "']");
  },
  submitHandler: function (form) {
    next();
  }
});