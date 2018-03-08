$("#profileForm").validate({
  rules: {
    name: {
      required: true,
      minlength: 2
    },
    email: {
      required: true,
      email: true
    }
  }
});

$("#profileForm").validate({
  errorClass: "invalid",
  validClass: "valid",
  errorPlacement: function (error, element) {
  $(element)
    .closest("#profileForm")
    .find("label[for='" + element.attr("id") + "']")
    .attr('data-error', error.text());
    console.log("label[for='" + element.attr("id") + "']");
  },
  submitHandler: function (form) {
    next();
  }
});