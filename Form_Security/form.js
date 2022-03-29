function Validate(Form) {
    if(Form.elements['mdp'].value !== Form.elements['mdp2'].value) {
        alert("Les mots de passes indiqué doivent être identiques");
        return false;
    }
    else {
        return true;
    }
}
