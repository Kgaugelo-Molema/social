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
    
function checkmemberfields(form)
{
    if (validString(form.membername.value) == false)
    {
        alert("Name field cannot be empty")
        return false
    }

    if (validString(form.membersurname.value) == false)
    {
        alert("Surname field cannot be empty")
        return false
    }
    
    if (validString(form.clubid.value) == false)
    {
        alert("Please select a social club")
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


