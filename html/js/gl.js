//When this page loads, the PHP script writes a JSON object to the page, which includes
//the account, description, type ID and type for each account
//This is a two-dimensional array. 

//This message will appear in account description, if the user enters a GL account that doesn't exist
const badAccount = 'Invalid Account!';

//As the postings are made, we need to keep track of the total debits & credits
let debits = 0.00;
let credits = 0.00;

/*Need to keep track of whether or not a posting amount has updated the 
  Total debits or credits. If not, what happens is the user can just
  enter and exit the amount field and continually update the debits and credits amounts
  However, if the account changes, is invalid or is blank, and there is a value
  in the amount field, we need to reverse the entry and set the boolean back
  to false
*/

let bool1 = false;
let bool2 = false;
let bool3 = false;
let bool4 = false;
let bool5 = false;
let bool6 = false;
let bool7 = false;
let bool8 = false;
let bool9 = false;
let bool10 = false;

//Grab references to the Debits & Credits fields
let fldDebits = document.getElementById('debits');
let fldCredits = document.getElementById('credits');

//function to undo any amount entered in the Amount field
function reverseEntry(fieldNumber,trType) {
    curDebits = getDrCr('D');
    curCredits = getDrCr('C');
    fldCombined = 'amount' + fieldNumber;
    elAmount = document.getElementById(fldCombined);
    postAmount = elAmount.value;
    /*
    //Debugging alert to make sure we are finding all the necessary values for calculation
    alert('Current Debits' + curDebits + "\n"
        + 'Current Credits ' + curCredits + "\n"
        + 'Posting Amount ' + postAmount + "\n"
        + 'Transaction Type ' + trType
    );
    */
   if(trType === 'D') {
       //alert('This was a Debit posting');
       curDebits = Number(curDebits - postAmount);
       fldDebits.value = curDebits;
       elAmount.value = '';
   }else if(trType === 'C') {
       //alert('This was a Credit posting');
       curCredits = Number(curCredits - postAmount);
       fldCredits.value = curCredits;
       elAmount.value = '';
   }

} //end function reverseEntry(fieldNumber, trType)

function getDrCr(t) {
    if(t === 'D') {
        return Number(fldDebits.value);
    } else if(t === 'C') {
        return Number(fldCredits.value);
    }
}

//Get references to the account and description fields for all 10 lines

const account1 = document.getElementById('account1');
const desc1 = document.getElementById('desc1');
const account2 = document.getElementById('account2');
const desc2 = document.getElementById('desc2');
const account3 = document.getElementById('account3');
const desc3 = document.getElementById('desc3');
const account4 = document.getElementById('account4');
const desc4 = document.getElementById('desc4');
const account5 = document.getElementById('account5');
const desc5 = document.getElementById('desc5');
const account6 = document.getElementById('account6');
const desc6 = document.getElementById('desc6');
const account7 = document.getElementById('account7');
const desc7 = document.getElementById('desc7');
const account8 = document.getElementById('account8');
const desc8 = document.getElementById('desc8');
const account9 = document.getElementById('account9');
const desc9 = document.getElementById('desc9');
const account10 = document.getElementById('account10');
const desc10 = document.getElementById('desc10');

/*
Add Event Listeners so that when the account is entered, the description field updates with the GL description
Because the user may enter an invalid account, we need to notify user and disable the amount field
Before executing the function, need to test that a value was actually entered. 
It is possible the user just hit tab without entering anything
There are three possible conditions wherein any amount posted to the total Debits or total Credits
need to be reversed
1. Invalid accounte entered
2. Account was changed
3. Account was delete and no value was in the field. User just tabbed out of a blank field. 
*/



account1.addEventListener('blur', () => {
    glAccount = account1.value;
    glAmount = document.getElementById('amount1');
    postAmount = glAmount.value;
    trType = document.getElementById('dc1').value;
    if(glAccount.length !== 0) {
        try {
            if(postAmount.length > 0) {
                reverseEntry(1,trType);
                bool1 = false;
            }
            glDescription = coa[glAccount]['description'];
            desc1.value = glDescription;
            glAmount.disabled = false; 
            glAmount.removeAttribute("readonly","readonly");
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(1,trType);
                bool1 = false;
            }
            
            desc1.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;
        }
    } else if(glAccount.length === 0) {
        //We again need to update the debits field if there was a value in amount1
        if(postAmount.length > 0) {
            reverseEntry(1,trType);
        }
            desc1.value = '';
            glAmount.value = '';
            glAmount.disabled = true;
            bool1 = false; 
    }
});

account2.addEventListener('blur', () => {
    glAccount = account2.value;
    glAmount = glAmount = document.getElementById('amount2');
    postAmount = glAmount.value;
    trType = document.getElementById('dc2').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc2.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(2,trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(2,trType);
            }
            
            desc2.value = badAccount;
            glAmount.disabled = true;
            glAmount.value = '';
        }
    }else if(glAccount.length === 0) {
        //If there was an amount entered, we need to reverse this
        if(postAmount.length > 0) {
            reverseEntry(2,trType);
        }
        desc2.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account3.addEventListener('blur', () => {
    glAccount = account3.value;
    glAmount = glAmount = document.getElementById('amount3');
    postAmount = glAmount.value;
    trType = document.getElementById('dc3').value;
    if(glAccount.length !== 0) {
        try{
            glDescription = coa[glAccount]['description'];
            desc3.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(3,trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(3,trType);
            }
            
            desc3.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;
        }
    }else if(glAccount.length === 0) {
        if(postAmount.length> 0) {
            reverseEntry(3,trType);
        }
        desc3.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account4.addEventListener('blur', () => {
    glAccount = account4.value;
    glAmount = glAmount = document.getElementById('amount4');
    postAmount = glAmount.value;
    trType = document.getElementById('dc4').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc4.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(4,trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(4,trType);
            }
            desc4.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;
        }
    } else if(glAccount.length === 0) {
        if(postAmount.length > 0) {
            reverseEntry(4,trType);
        }
        desc4.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account5.addEventListener('blur', () => {
    glAccount = account5.value;
    glAmount = document.getElementById('amount5');
    postAmount = glAmount.value;
    trType = document.getElementById('dc5').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc5.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(5,trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(5, trType);
            }
            desc5.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;        
        }
    } else if(glAccount.length === 0) {
        if(postAmount.length > 0) {
            reverseEntry(5,trType);
        }
        desc5.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account6.addEventListener('blur', () => {
    glAccount = account6.value;
    glAmount = document.getElementById('amount6');
    postAmount = glAmount.value;
    trType = document.getElementById('dc6').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc6.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(6, trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(6, trType);
            }
            desc6.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;
        }
    } else if(glAccount.length === 0) {
        if(postAmount.length > 0) {
            reverseEntry(6, trType);
        }
        desc6.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account7.addEventListener('blur', () => {
    glAccount = account7.value;
    glAmount = document.getElementById('amount7');
    postAmount = glAmount.value;
    trType = document.getElementById('dc7').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc7.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(7, trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(7, trType);
            }
            desc7.value = "Invalid Account!";
            glAmount.value = '';
            glAmount.disabled = true;
        }
    } else if(glAccount.length === 0) {
        if(postAmount.length > 0) {
            reverseEntry(7, trType);
        }
        desc7.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account8.addEventListener('blur', () => {
    glAccount = account8.value;
    glAmount = document.getElementById('amount8');
    postAmount = glAmount.value;
    trType = document.getElementById('dc8').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc8.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(8, trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(8, trType);
            }
            desc8.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;
        }
    } else if(glAccount.length === 0) {
        if(postAmount.length > 0) {
            reverseEntry(8, trType);
        }
        desc8.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account9.addEventListener('blur', () => {
    glAccount = account9.value;
    glAmount = document.getElementById('amount9');
    postAmount = glAmount.value;
    trType = document.getElementById('dc9').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc9.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(9, trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(9, trType);
            }
            desc9.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;
        }
    } else if(glAccount.length === 0) {
        if(postAmount.length > 0) {
            reverseEntry(9, trType);
        }
        desc9.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
});

account10.addEventListener('blur', () => {
    glAccount = account10.value;
    glAmount = document.getElementById('amount10');
    postAmount = glAmount.value;
    trType = document.getElementById('dc10').value;
    if(glAccount.length !== 0) {
        try {
            glDescription = coa[glAccount]['description'];
            desc10.value = glDescription;
            glAmount.disabled = false;
            glAmount.removeAttribute("readonly","readonly");
            if(postAmount.length > 0) {
                reverseEntry(10, trType);
            }
        } catch(err) {
            if(postAmount.length > 0) {
                reverseEntry(10, trType);
            }
            desc10.value = badAccount;
            glAmount.value = '';
            glAmount.disabled = true;
        }
    } else if(glAccount.length === 0) {
        if(postAmount.length > 0) {
            reverseEntry(10, trType);
        }
        desc10.value = '';
        glAmount.value = '';
        glAmount.disabled = true;
    }
    
});

/*
Add Event Listener to the control type drop downs. 
This will enable or disable the control field. 
If no selection is made, we want to prevent the user from entering a control
when that control will have no classication
*/

const type1 = document.getElementById('type1');
const type2 = document.getElementById('type2');
const type3 = document.getElementById('type3');
const type4 = document.getElementById('type4');
const type5 = document.getElementById('type5');
const type6 = document.getElementById('type6');
const type7 = document.getElementById('type7');
const type8 = document.getElementById('type8');
const type9 = document.getElementById('type9');
const type10 = document.getElementById('type10');

//Control fields to activate/deactivate depending on selection
const control1 = document.getElementById('control1');
const control2 = document.getElementById('control2');
const control3 = document.getElementById('control3');
const control4 = document.getElementById('control4');
const control5 = document.getElementById('control5');
const control6 = document.getElementById('control6');
const control7 = document.getElementById('control7');
const control8 = document.getElementById('control8');
const control9 = document.getElementById('control9');
const control10 = document.getElementById('control10');

type1.addEventListener('change', () => {
   const controlType = type1.value;
   if(controlType !== 'none') {
       control1.disabled = false;
   } else if(controlType === 'none') {
       control1.value = '';
       control1.disabled = true;
   }
});

type2.addEventListener('change', () => {
    const controlType = type2.value;
    if(controlType !== 'none') {
        control2.disabled = false;
    } else if(controlType === 'none') {
        control2.value = '';
        control2.disabled = true;
    }
});

type3.addEventListener('change', () => {
    const controlType = type3.value;
    if(controlType !== 'none') {
        control3.disabled = false;
    } else if(controlType === 'none') {
        control3.value = '';
        control3.disabled = true;
    }
});

type4.addEventListener('change', () => {
    const controlType = type4.value;
    if(controlType !== 'none') {
        control4.disabled = false;
    } else if(controlType === 'none') {
        control4.value = '';
        control4.disabled = true;
    }
});

type5.addEventListener('change', () => {
    const controlType = type5.value;
    if(controlType !== 'none') {
        control5.disabled = false;
    } else if(controlType === 'none') {
        control5.value = '';
        control5.disabled = true;
    }
});

type6.addEventListener('change', () => {
    const controlType = type6.value;
    if(controlType !== 'none') {
        control6.disabled = false;
    } else if(controlType === 'none') {
        control6.value = '';
        control6.disabled = true;
    }
});

type7.addEventListener('change', () => {
    const controlType = type7.value;
    if(controlType !== 'none') {
        control7.disabled = false;
    } else if(controlType === 'none') {
        control7.value = '';
        control7.disabled = true;
    }
});

type8.addEventListener('change', () => {
    const controlType = type8.value;
    if(controlType !== 'none') {
        control8.disabled = false;
    } else if(controlType === 'none') {
        control8.value = '';
        control8.disabled = true;
    }
});

type9.addEventListener('change', () => {
    const controlType = type9.value;
    if(controlType !== 'none') {
        control9.disabled = false;
    } else if(controlType === 'none') {
        control9.value = '';
        control9.disabled = true;
    }
});

type10.addEventListener('change', () => {
    const controlType = type10.value;
    if(controlType !== 'none') {
        control10.disabled = false;
    } else if(controlType === 'none') {
        control10.value = '';
        control10.disabled = true;
    }
});

/*Create references to and add EventListeners for the amount fields that will
update the debit and credit amount as they type in transactions
*/

const amount1 = document.getElementById('amount1');
const amount2 = document.getElementById('amount2');
const amount3 = document.getElementById('amount3');
const amount4 = document.getElementById('amount4');
const amount5 = document.getElementById('amount5');
const amount6 = document.getElementById('amount6');
const amount7 = document.getElementById('amount7');
const amount8 = document.getElementById('amount8');
const amount9 = document.getElementById('amount9');
const amount10 = document.getElementById('amount10');


amount1.addEventListener('blur', () => {
    curDebits = Number(fldDebits.value);
    curCredits = Number(fldCredits.value);
    trType = document.getElementById('dc1').value;
    glAccount = account1.value;
    glAmount = Number(amount1.value);
    if(trType !== null && glAccount !== null && glAmount > 0 && bool1 === false) {
        bool1 = true;
        amount1.setAttribute("readonly","readonly");
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else if(bool1 === true) {
        return;
    } else {
        alert('An error occured');
        fldDebits.value = curDebits - glAmount;
        fldCredits.value = curCredits;
        amount1.value = '';
        account1.value = '';
        desc1.value = '';
    }
});

amount2.addEventListener('blur', () => {
    curDebits = Number(fldDebits.value);
    curCredits = Number(fldCredits.value);
    trType = document.getElementById('dc2').value;
    glAccount = account2.value;
    glAmount = Number(amount2.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }  
    } else {
        alert('An error occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount2.value = '';
        account2.value = '';
        desc2.value = '';
    }
    amount2.setAttribute("readonly","readonly");
});

amount3.addEventListener('blur', () => {
    curDebits = Number(fldDebits.value);
    curCredits = Number(fldCredits.value);
    trType = document.getElementById('dc3').value;
    glAccount = account3.value;
    glAmount = Number(amount3.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount3.value = '';
        account3.value = '';
        desc3.value = '';
    }
    amount3.setAttribute("readonly","readonly");
});

amount4.addEventListener('blur', () => {
    curDebits = Number(fldDebits.value);
    curCredits = Number(fldCredits.value);
    trType = document.getElementById('dc4').value;
    glAccount = account4.value;
    glAmount = Number(amount4.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount4.value = '';
        account4.value = '';
        desc4.value = '';
    }
    amount4.setAttribute("readonly","readonly");
}); 

amount5.addEventListener('blur', () => {
    curDebits = Number(fldDebits.value);
    curCredits = Number(fldCredits.value);
    trType = document.getElementById('dc5').value;
    glAccount = account5.value;
    glAmount = Number(amount5.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits = curCredits;
        } else if (trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount5.value = '';
        account5.value = '';
        desc5.value = '';
    }
    amount5.setAttribute("readonly","readonly");
});

amount6.addEventListener('blur', () => {
    curDebits = getDrCr('D');
    curCredits = getDrCr('C');
    trType = document.getElementById('dc6').value;
    glAccount = account6.value;
    glAmount = Number(amount6.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount6.value = '';
        account6.value = '';
        desc6.value = '';
    }
    amount6.setAttribute("readonly","readonly");
});

amount7.addEventListener('blur', () => {
    curDebits = getDrCr('D');
    curCredits = getDrCr('C');
    trType = document.getElementById('dc7').value;
    glAccount = account7.value;
    glAmount = Number(amount7.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount7.value = '';
        account7.value = '';
        desc7.value = '';
    }
    amount7.setAttribute("readonly","readonly");
});

amount8.addEventListener('blur', () => {
    curDebits = getDrCr('D');
    curCredits = getDrCr('C');
    trType = document.getElementById('dc8').value;
    glAccount = account8.value;
    glAmount = Number(amount8.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount8.value = '';
        account8.value = '';
        desc8.value = '';
    }
    amount8.setAttribute("readonly","readonly");
});

amount9.addEventListener('blur', () => {
    curDebits = getDrCr('D');
    curCredits = getDrCr('C');
    trType = document.getElementById('dc9').value;
    glAccount = account9.value;
    glAmount = Number(amount9.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount9.value = '';
        account9.value = '';
        desc9.value = '';
    }
    amount9.setAttribute("readonly","readonly");
});

amount10.addEventListener('blur', () => {
    curDebits = getDrCr('D');
    curCredits = getDrCr('C');
    trType = document.getElementById('dc10').value;
    glAccount = account10.value;
    glAmount = Number(amount10.value);
    if(trType !== null && glAccount !== null && glAmount > 0) {
        if(trType === 'D') {
            totDebits = Number(curDebits + glAmount);
            fldDebits.value = totDebits;
            fldCredits.value = curCredits;
        } else if(trType === 'C') {
            totCredits = Number(curCredits + glAmount);
            fldCredits.value = totCredits;
            fldDebits.value = curDebits;
        }
    } else {
        alert('An Error Occured');
        fldDebits.value = curDebits;
        fldCredits.value = curCredits;
        amount10.value = '';
        account10.value = '';
        desc10.value = '';
    }
    amount10.setAttribute("readonly","readonly");
}); 

const validateButton = document.getElementById('validate');
const saveButton = document.getElementById('save');
const resetButton = document.getElementById('reset');

validateButton.onclick = validatePostings;


function validatePostings() {
    curDebits = getDrCr('D');
    curCredits = getDrCr('C');
    curBalance = 0.00;
    if(curDebits > curCredits) {
        curBalance = curDebits - curCredits;
    } else if(curCredits > curDebits) {
        curBalance = curCredits - curDebits;
    }
    if(curBalance === 0) {
        var answer = confirm("This posting balances" + "\n" + "Are you ready to post this entry?");
        if(answer === true) {
            saveButton.disabled = false;
            saveButton.style.color = "Red";
            saveButton.style.fontWeight = "bold";
        }
        
    } else {
        alert('This posting does not balance. The is a difference of ' + curBalance + '. Please correct and try again');
        saveButton.disabled = true;
    }
}