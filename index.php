<html>  
<head>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />  
<script src="http://code.jquery.com/jquery-1.8.3.js" type="text/javascript"></script>  
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js" type="text/javascript"></script>  
<link href="../Content/popup.css" rel="stylesheet" />  
<style>  
#tbl1 {  
width: 80%;  
text-align: center;  
}  
#tbl1 td {  
width: 200px;  
}  

body {  
font-size: 62.5%;  
}  
label, input {  
display: block;  
}  
input.text {  
margin-bottom: 12px;  
width: 95%;  
padding: .4em;  
}  
fieldset {  
padding: 0;  
border: 0;  
margin-top: 25px;  
}  
h1 {  
font-size: 1.2em;  
margin: .6em 0;  
}  
div#users-contain {  
width: 350px;  
margin: 20px 0;  
}  
div#users-contain table {  
margin: 1em 0;  
border-collapse: collapse;  
width: 100%;  
}  
div#users-contain table td, div#users-contain table th {  
border: 1px solid #eee;  
padding: .6em 10px;  
text-align: left;  
}  
.ui-dialog .ui-state-error {  
padding: .3em;  
}  
.validateTips {  
border: 1px solid transparent;  
padding: 0.3em;  
}  
  
#dialog-form {  
display: none;   
}  
<style>
</head>
<body>
<table id="tbl1">  
    <tr>  
        <td>PO Number</td>  
        <td>@Html.TextBox("POrderNumber", (string)ViewBag.Title)</td>  
        <td>Select Date</td>  
        <td>  
            <input type="text" id="datepicker" style="width:150px" />  
        </td>  
    </tr>  
    <tr>  
        <td>Select Vendor</td>  
        <td >  
@Html.DropDownList("lstVendor", ViewBag.lstVendor as IEnumerable  
            <SelectListItem>, "Select Vendor")  
            </td>  
        </tr>  
    </table>  
    <div id="dialog-form" title="Add New Item">  
        <p class="validateTips">  
All form fields are required.  
</p>  
        <form>  
            <fieldset>  
                <label for="productname">  
Product Name  
</label>  
                <input type="text" name="productname" id="product-name" value="" class="text ui-widget-content ui-corner-all" />  
                <label for="Productdesc">  
Product Desc  
</label>  
                <input type="text" name="Productdesc" id="Product-Desc" value="" class="text ui-widget-content ui-corner-all" />  
                <label for="Price">  
Price  
</label>  
                <input type="text" name="Price" id="Price" value="" class="text ui-widget-content ui-corner-all" />  
                <label for="Discount">  
Discount  
</label>  
                <input type="text" name="Discount" id="Discount" value="" class="text ui-widget-content ui-corner-all" />  
            </fieldset>  
        </form>  
    </div>  
    <div id="users-contain" class="ui-widget" style="width:auto">  
        <h1>List Of Items:</h1>  
        <table id="tblProducts" class="ui-widget ui-widget-content" style="width:auto">  
            <thead>  
                <tr class="ui-widget-header ">  
                    <th style="display:none;">ProductID</th>  
                    <th>Product Name</th>  
                    <th>Product Desc</th>  
                    <th>Price</th>  
                    <th>Discount</th>  
                    <th>Final Price</th>  
                    <th colspan="2">Actions</th>  
                </tr>  
            </thead>  
            <tbody></tbody>  
            <tfoot>  
                <tr>  
                    <td colspan="4" style="text-align:right">Grand Total : </td>  
                    <td>  
                        <label id="lbltotal"></label>  
                    </td>  
                </tr>  
            </tfoot>  
        </table>  
    </div>  
    <button id="Add-Product">  
Add New Item  
</button>  
    <script>  
$(function () {  
var editrow;  
function checkrows() {  
var rowcount = $("#tblProducts tbody tr").length;  
if (rowcount == 0) {  
$("#tblProducts tfoot tr").hide();  
}  
}  
$("#datepicker").datepicker({ dateFormat: 'dd-mm-yy' });  
var new_dialog = function (type, row)  
{  
var dlg = $("#dialog-form").clone();  
var pname = dlg.find(("#product-name")),  
pdesc = dlg.find(("#Product-Desc")),  
price = dlg.find(("#Price")),  
discount = dlg.find(("#Discount"));  
typetype = type || 'Create';  
title = "Add Item";  
var config =  
{  
autoOpen: true,  
height: 400,  
width: 350,  
modal: true,  
buttons:  
{  
"Save": save_data,  
"Cancel": function ()  
{  
dlg.dialog("close");  
}  
},  
close: function ()  
{  
dlg.remove();  
}  
};  
if (type === 'Edit')  
{  
config.title = "Edit Item";  
get_data();  
config.buttons['Save'] = function ()  
{  
var fprice = 0;  
//var disc = discount.val() / 100;  
if (discount.val() > 0) {  
fprice = price.val() - (price.val() * (discount.val() / 100));  
}  
else {  
fprice = price.val();  
}  
//row.remove();  
var new_row = "  
        <tr>" + "  
            <td>" + pname.val() + "</td>" + "  
            <td>" + pdesc.val() + "</td>" + "  
            <td>" + price.val() + "</td>" + "  
            <td>" + discount.val() + "</td>" + "  
            <td>" + fprice + "</td>" + "  
            <td>  
                <a href='' class='edit'>Edit</a>  
            </td>" + "  
            <td>  
                <span class='delete'>  
                    <a href=''>Delete</a>  
                </span>  
            </td>" + "  
        </tr>";  
editrow.replaceWith(new_row);  
//row.replaceWith(new_row);  
dlg.dialog("close");  
findTotal();  
//save_data();  
};  
}  
dlg.dialog(config);  
function get_data() {  
var _pname = $(row.children().get(0)).text(),_pdesc = $(row.children().get(1)).text()  
_price = $(row.children().get(2)).text(), _discount = $(row.children().get(3)).text();  
//_fprice=$(row.children().get(4)).text();  
pname.val(_pname);  
pdesc.val(_pdesc);  
price.val(_price);  
discount.val(_discount);  
}  
function save_data() {  
var fprice=0;  
//var disc = discount.val() / 100;  
if (discount.val() > 0)  
{  
fprice = price.val()-(price.val() * (discount.val() / 100));  
}  
else {  
fprice = price.val();  
}  
$("#tblProducts tbody").append("  
        <tr>" + "  
            <td>" + pname.val() + "</td>" + "  
            <td>" + pdesc.val() + "</td>" + "  
            <td>" + price.val() + "</td>" + "  
            <td>" + discount.val() + "</td>" + "  
            <td>" + fprice + "</td>" + "  
            <td>  
                <a href='' class='edit'>Edit</a>  
            </td>" + "  
            <td>  
                <span class='delete'>  
                    <a href=''>Delete</a>  
                </span>  
            </td>" + "  
        </tr>");  
dlg.dialog("close");  
findTotal();  
}  
};  
checkrows();  
var row_total=0;  
function findTotal() {  
row_total = 0;  
$("#tblProducts tbody tr").each(function () {  
row_total += Number($(this).find("td:eq(4)").html());  
});  
$("#lbltotal").html(row_total);  
$("#tblProducts tfoot tr").show();   
//alert(row_total);  
}  
$(document).on('click', 'span.delete', function ()  
{  
$(this).closest('tr').find('td').fadeOut(1000,  
function ()  
{  
// alert($(this).text());  
$(this).parents('tr:first').remove();  
findTotal();  
checkrows();  
});  
return false;  
});  
$(document).on('click', 'td a.edit', function () {  
new_dialog('Edit', $(this).parents('tr'));  
editrow = $(this).parents('tr');  
return false;  
});  
$("#Add-Product").button().click(new_dialog);  
});  
    </script>  
//Css  
