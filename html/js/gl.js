const account1 = document.getElementById('account1');

function getDescription() {
    console.log("getDescription() invoked");
}

account1.addEventListener('blur', () => alert(coa[account1.value]['description']));