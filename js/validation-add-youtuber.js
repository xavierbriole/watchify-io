$("#youtuberForm").validate({
  rules: {
    username: {
      required: true
    },
    name: {
      required: true
    },
    channelID: {
      required: true
    },
    profileIMG: {
      required: false
    }
  }
});

$("#youtuberForm").validate({
  errorClass: "invalid",
  validClass: "valid",
  errorPlacement: function (error, element) {
  $(element)
    .closest("#youtuberForm")
    .find("label[for='" + element.attr("id") + "']")
    .attr('data-error', error.text());
    console.log("label[for='" + element.attr("id") + "']");
  },
  submitHandler: function (form) {
    next();
  }
});