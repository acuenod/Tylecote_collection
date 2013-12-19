function ChangeColor(tableRow, highLight)
{
    if (highLight)
    {
      tableRow.className='normalActive';
    }
    else
    {
      tableRow.className='normal';
    }
}
function ChangeColorHeader(cell, highLight)
{
    if (highLight)
    {
      cell.className='normalActiveth';
    }
    else
    {
      cell.className='normalth';
    }
}
function DoNav(theUrl)
{
    document.location.href = theUrl;
}


