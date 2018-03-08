$("#passwordForm").validate({
  rules: {
    password_current: {
      required: true,
      minlength: 1
    },
    password_new: {
      required: true,
      minlength: 6
    },
    password_new_again: {
      required: true,
      minlength: 6,
      equalTo: "#password_new"
    }
  }
});

$("#passwordForm").validate({
  errorClass: "invalid",
  validClass: "valid",
  errorPlacement: function (error, element) {
  $(element)
    .closest("#passwordForm")
    .find("label[for='" + element.attr("id") + "']")
    .attr('data-error', error.text());
    console.log("label[for='" + element.attr("id") + "']");
  },
  submitHandler: function (form) {
    next();
  }
});