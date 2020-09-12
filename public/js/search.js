$(function (){
    console.log('width: ' + getWidth());
    console.log('height: ' + getHeight());

    var field_width = getWidth() / 3.196347031963470319634703196347;

    $(".dropdown-content").css("width", field_width);

    $("#myInput").css('width', field_width - 2);
});

function filterFunction() {
    var input, filter, ul, li, a, i;

    input = document.getElementById("myInput");

    filter = input.value.toUpperCase();

    div = document.getElementById("myDropdown");

    a = div.getElementsByTagName("a");

    for (i = 0; i < a.length; i++) {

        txtValue = a[i].textContent || a[i].innerText;

        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}
