function validate() {
    let name = document.getElementById('name').value;
    console.log(name);
    if (name == '') {
        document.getElementById('name-error').innerHTML = 'name is required*';
        return false;
    } else {
        document.getElementById('name-error').innerHTML = '';
    }
    return true;

}