function start(beginn)
{
setup(beginn,"form1");
repeat()
}

function repeat()
{
down("form1");
setTimeout("repeat()",1000)
}

function setup(day,box)
{today=(new Date()).getTime();
the_day=(new Date(day)).getTime();
time=(the_day-today);
document.forms[box].time2.value=time
}

function down(box)
{
document.forms[box].time2.value=document.forms[box].time2.value-1000;
time=document.forms[box].time2.value;
days=(time-(time%86400000))/86400000;
time=time-(days*86400000);
//Winterzeit 
//hours=(time-(time%3600000-3600000))/3600000;
//time=time-(hours*3600000-3600000);
//Sommerzeit
hours=(time-(time%3600000))/3600000;
time=time-(hours*3600000);
mins=(time-(time%60000))/60000;
time=time-(mins*60000);
secs=(time-(time%1000))/1000;
if(days==1)out="  1 Tag, ";
else out="  Noch "+days+" Tage und ";
if(hours<10)out=out+"0";out=out+hours+":";
if(mins<10)out=out+"0";out=out+mins+":";
if(secs<10)out=out+"0";out=out+secs;
if(days+hours+mins+secs>1)document.forms[box].time.value=out;
else document.forms[box].time.value=("Wir feiern Schuetzenfest!")
}