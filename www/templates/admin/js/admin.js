/**
 * Получение данных с формы
 *
 */
function getData(obj_form){
    var hData = {};
    $('input, textarea, select',  obj_form).each(function(){
        if(this.name && this.name!=''){
            hData[this.name] = this.value;
            console.log('hData[' + this.name + '] = ' + hData[this.name]);
        }
    });
    return hData;
};

function newCategory(){
    console.log("js - newCategory");
    var postData = getData('#blockNewCategory');

    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/addnewcat/",
        data: postData,
        dataType: 'json',
        success: function(data){
            if(data['success']) {
                alert(data['message']);
                $('#newCategoryName').val('');
            }else{
                alert(data['message']);
            }
        }
    });
}

function updateCat(itemId){
    console.log("js - updateCat");

    var parentId = $('#parentId_' + itemId).val();
    var newName = $('#itemName_' + itemId).val();
    var postData = {itemId: itemId, parentId: parentId, newName: newName};


    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/updatecategory/",
        data: postData,
        dataType: 'json',
        success: function(data){
            if(data['success']) {
                alert(data['message']);
            }
        }
    });
}

/**
 *  Функция добавления нового продукта
 *
 *
 *  @return в случае успеха обновятся данные корзины на странице
 */
function addProduct(){
    console.log("js - addProduct()");

    var itemName = $('#newItemName').val();
    var itemPrice = $('#newItemPrice').val();
    var itemCatId = $('#newItemCatId').val();
    var itemDesc = $('#newItemDesc').val();

    var posData = {itemName: itemName, itemPrice: itemPrice, itemCatId: itemCatId, itemDesc: itemDesc};

    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/addproduct/",
        data: posData,
        dataType: 'json',
        success: function(data){
            alert(data['message']);
            if(data['success']){
                $('#newItemName').val('');
                $('#newItemPrice').val('');
                $('#newItemCatId').val('');
                $('#newItemDesc').val('');
            }
        }
    });
}

/**
 * Изменение данных продукта
 *
 * @param itemId
 */

function updateProduct(itemId){
    console.log("js - updateProduct");

    var itemName = $('#itemName_' + itemId).val();
    var itemPrice = $('#itemPrice_' + itemId).val();
    var itemCatId = $('#itemCatId_' + itemId).val();
    var itemDesc = $('#itemDesc_' + itemId).val();

    var itemStatus = $('#itemStatus_' + itemId).attr('checked');

    if(! itemStatus){
        itemStatus = 1
    }else {
        itemStatus = 0
    }

    var postData = {itemId: itemId, itemName: itemName, itemPrice: itemPrice,
                    itemCatId: itemCatId, itemDesc: itemDesc, itemStatus: itemStatus};


    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/updateproduct/",
        data: postData,
        dataType: 'json',
        success: function(data){
                alert(data['message']);
        }
    });
}
