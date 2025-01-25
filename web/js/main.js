
/*load olinyotganda, dropdownload kerakli malumotlarni userga chiqarish*/
$("#loads-broker_id").change(function(){
    var value = this.value;

    var name = $("#name");
    var phone = $("#phone");
    var email = $("#email");
    var address = $("#address");

    if(value == null || value == '') {
        name.val('');
        phone.val('');
        email.val('');
        address.val('');
    }

    $.ajax('/site/broker-data', {
        type: 'POST',  // http method
        data: { broker_id: value },  // data to submit
        success: function (data) {
            name.val(data['broker_name']);
            phone.val(data['broker_phone']);
            email.val(data['broker_email']);
            address.val(data['broker_address']);
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log(errorMessage)
        }
    });
    console.log(value);

})
