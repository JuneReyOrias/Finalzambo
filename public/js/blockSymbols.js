function blockSymbolsAndNumbers(event) {
    const charCode = event.which || event.keyCode;
    // Allow only letters (A-Z, a-z) and space (32)
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode === 32) {
        return true;
    }
    return false;
}