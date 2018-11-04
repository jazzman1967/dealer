const form = document.forms.sale;

const calcButton = document.getElementById('calculate');
const resetButton = document.getElementById('reset');

const priceField = document.getElementById('price');
const origPriceField = document.getElementById('originalprice');
const totalField = document.getElementById('total');
const saveButton = document.getElementById('save');
const taxRate = document.getElementById('taxrate');
const taxAmount = document.getElementById('taxamount');

const optionCodes = form.options;
const optionValues = form.sale_amt;
const optTotalDollars = form.optionsTotal;

document.body.onload = checkBoxEventListener;

calcButton.onclick = calculateForm;
resetButton.onclick = resetSale;

function calculateForm() {
    const carDollars = Number(priceField.value);
    const taxPercent = Number(taxRate.value / 100);
    //Grab the value of options
    const addedOptions = Number(optTotalDollars.value);
    //generate a subtotal
    const subTotal = Number(addedOptions + carDollars);
    var taxDollars = 0.00;
    var totalDollars = 0.00;
    //If the taxAmount field is blank, this is the first time loading the page, use the standard tax rates
    if (taxAmount.value === "") {
        taxDollars = Number(subTotal * taxPercent);
        taxAmount.value = taxDollars;
        //If the taxAmount field is not blank, then amounts were overridden and we need to use the field values
        //rather than calculate the tax
    } else if(taxAmount.value !== "") {
        taxDollars = Number(taxAmount.value);
        taxAmount.value = taxDollars;
        //If the taxAmount is zero, just add up the options and car sale
    } else if(taxAmount.value == "0") {
        taxDollars = Number(0.00);
        taxAmount.value = taxDollars;
    }
    //After calculating tax, we add up the figures
    totalDollars = Number(subTotal + taxDollars);
    totalField.value = totalDollars;
    saveButton.disabled = false;
}

function resetSale() {
    //Will need to uncheck all the checkboxes
    for(i = 0; i < optionCodes.length; i++) {
        optionCodes[i].checked = false;
    }
    
    const origPriceField = document.getElementById('originalprice');
    const originalPrice = origPriceField.value;
    priceField.value = originalPrice;
    taxAmount.value = "";
    totalField.value = "";
    optTotalDollars.value = "";
    saveButton.disabled = true;
}

function checkBoxEventListener() {
    for(i = 0; i < optionCodes.length; i++) {
        optionCodes[i].addEventListener('click',getOptions,false);
    }
}

function getOptions() {
    let optionsAmount = 0.00;
    for(i = 0; i < optionCodes.length; i++) {
        if(optionCodes[i].checked === true) {
            optionsAmount += Number(optionValues[i].value);
        }
    }
    optTotalDollars.value = optionsAmount;
}