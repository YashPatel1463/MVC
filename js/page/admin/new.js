function validate() {
    let name = document.getElementById('name').value;
    let description = document.getElementById('description').value;
    let price = document.getElementById('price').value;
    let category = document.getElementById('category').value;
    let size = document.getElementById('size').value;
    let brand = document.getElementById('brand').value;
    let warranty = document.getElementById('warranty').value;
    let weight = document.getElementById('weight').value;
    let model = document.getElementById('model').value;
    let material = document.getElementById('material').value;
    let t_and_c = document.getElementById('t_and_c').value;

    if (name == '' || name == null || !/^[a-zA-Z _]+$/.test(name)) {
        document.getElementById('name-error').innerHTML = 'name can not be empty and not have any special character or numbers.';
        return false;
    } else {
        document.getElementById('name-error').innerHTML = '';
    }

    if (category == '') {
        document.getElementById('category-error').innerHTML = 'Please select category.*';
        return false;
    } else {
        document.getElementById('category-error').innerHTML = '';
    }

    if (description == '' || !/^[a-zA-Z0-9 _]+$/.test(description)) {
        document.getElementById('description-error').innerHTML = 'description is required*';
        return false;
    } else {
        document.getElementById('description-error').innerHTML = '';
    }

    if (price == '' || price <= 0) {
        document.getElementById('price-error').innerHTML = 'Price can not be less than or equal to zero.*';
        return false;
    } else {
        document.getElementById('price-error').innerHTML = '';
    }

    if (size == '') {
        document.getElementById('size-error').innerHTML = 'size is required*';
        return false;
    } else {
        document.getElementById('size-error').innerHTML = '';
    }

    if (brand == '') {
        document.getElementById('brand-error').innerHTML = 'brand is required*';
        return false;
    } else {
        document.getElementById('brand-error').innerHTML = '';
    }

    if (warranty == '' || warranty > 0) {
        document.getElementById('warranty-error').innerHTML = 'warranty is required*';
        return false;
    } else {
        document.getElementById('warranty-error').innerHTML = '';
    }

    if (weight == '') {
        document.getElementById('weight-error').innerHTML = 'weight is required*';
        return false;
    } else {
        document.getElementById('weight-error').innerHTML = '';
    }

    if (model == '') {
        document.getElementById('model-error').innerHTML = 'model is required*';
        return false;
    } else {
        document.getElementById('model-error').innerHTML = '';
    }

    if (material == '') {
        document.getElementById('material-error').innerHTML = 'material is required*';
        return false;
    } else {
        document.getElementById('material-error').innerHTML = '';
    }

    if (t_and_c == '') {
        document.getElementById('t_and_c-error').innerHTML = 'Terms and Condition is required*';
        return false;
    } else {
        document.getElementById('t_and_c-error').innerHTML = '';
    }

    return true;

}