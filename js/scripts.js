function validString(str) 
{
    if ((str.length == 0) || (str == 'none'))
        {return false}
    else
        {return true}
}

function checkclubname(form)
{
    alert("Name field cannot be empty")
    if(validString(form.clubname.value) == false)
    {
        alert("Name field cannot be empty")
        return false
    }
}
    
function checksocialclubfields(form)
{
    if (validString(form.clubname.value) == false)
    {
        alert("Please enter club name")
        return false
    }

    if (validString(form.target.value) == false)
    {
        alert("Please enter monthly membership target")
        return false
    }
    
    if (validString(form.fee.value) == false)
    {
        alert("Please enter monthly membership fee")
        return false
    }
}

function checkclubname(form)
{
    if (validString(form.clubname.value) == false)
    {
        alert("Club name cannot be empty")
        return false
    }
}

function checkmemberfields(form)
{
    if (validString(form.membername.value) == false)
    {
        alert("Please enter member name")
        return false
    }
    if (validString(form.membersurname.value) == false)
    {
        alert("Please enter member surname")
        return false
    }
}

function checkcontributionfields(form)
{
    if (validString(form.memberid.value) == false)
    {
        alert("Please select club member")
        return false
    }    
    if (validString(form.fee.value) == false)
    {
        alert("Please enter member contribution")
        return false
    }    
}
