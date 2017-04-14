var sTrmText
function alertMessage(obj,msg)
{
	alert(msg);
	obj.focus();
	return false;
}

function Tarea(obj,len)
{ 
	if (obj.value.length>len)
		obj.value= obj.value.substring(0,len)
}
function validate_year(ob)
{	   
	var str	   	
	s=ob.value
	str=""
	if (s.length >4)
		str=1
	 		
	bag="0123456789"
	for (i = 0; i < s.length; i++)
	{   
    	c = s.charAt(i)
	    if (bag.indexOf(c) == -1) 
			str=1
	}
	if(str==1)
	{
		ob.focus()			
		return false
	}
}

function Trimcr(ob)
{
	sTrmText=ob.value
	var bFirstTime = "T";
	var sSpace = "";
	var sCurrChar = "";
	var sRtnString = "";

	for(nI=0; nI<sTrmText.length;nI++) 
	{
		sCurrChar=sTrmText.charAt(nI);
		if(sCurrChar=="\n" || sCurrChar=="\r")
		{
			sSpace=sSpace+" ";
		}
		else
		{
			if (bFirstTime=="T")
			{
				sRtnString=sCurrChar;
				bFirstTime="F";
			}
			else
			{
				sRtnString=sRtnString+sSpace+sCurrChar;
			}
			sSpace="";
		}
	}
	ob.value=sRtnString
	return sRtnString;
}

function isOnlyZero(obj)
{
	var str = obj.value.toString();

	len = str.length;

	for ( i = 0 ; i < len ; i++ )
	{
         if ( str.charAt(i) != '0')
             return false ;
    }
}

function Trimzero(ob)
{
	if(isOnlyZero(ob)==true)
	{
		ob.value="";
		return false;
	}
}

function Trim(obj)
{
	var sTrmText=obj.value;

	var bFirstTime = "T";
	var sSpace = "";
	var sCurrChar = "";
	var sRtnString = "";

	for(nI=0;nI<sTrmText.length;nI++) 
	{
		sCurrChar=sTrmText.charAt(nI);
		if (sCurrChar==" ")
		{
			sSpace=sSpace+" ";
		}
		else
		{
			if (bFirstTime=="T")
			{
				sRtnString=sCurrChar;
				bFirstTime="F";
			}
			else
			{
				sRtnString=sRtnString+sSpace+sCurrChar;
			}
			sSpace="";
		}
	}
	obj.value=sRtnString
	return sRtnString;
}

function validate_int(ob)
{	  
	var str	   	
	s=ob.value
	str=""
	bag="0123456789-() "
	for (i = 0; i < s.length; i++)
	{   
    	c = s.charAt(i)
	    if (bag.indexOf(c) == -1)
	    str=1
	}
	if(str==1)
	{
		ob.focus()			
		return false
	}
}

//CODE FOR VALID NAMES
	
function validate_char(ob)
{
	var s=ob.value
	dstr=""
	var str
	bag="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ. " 
		
	for (i=0;i<s.length;i++)
	{   
     	c = s.charAt(i)
		if (bag.indexOf(c)==-1) 
			str=1		  
		if(s.charAt(i)=="." && s.charAt(i+1)==".")
			str=1
	}	
	if(str==1)
		return false;
}	


function validate_url(ob)
{
	s=ob.value
	dstr=""
	var str
	bag="0987654321abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ./:" 
		
	for (i = 0;i < s.length; i++)
	    {   
     	 	c = s.charAt(i)
		if (bag.indexOf(c) == -1) 
			str=1		  
		if(s.charAt(i)=="." && s.charAt(i+1)==".")
			str=1
	   	}	

	if(str==1)
		return false;
}	

function validate_charwithspaces(ob)
{
	s=ob.value
	dstr=""
	var str
	bag="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,.'-/* " 
	for (i=0;i<s.length;i++)
	    {   
     	 	c = s.charAt(i)
		if (bag.indexOf(c) == -1) 
			str=1		  
		if(s.charAt(i)=="."&&s.charAt(i+1)==".")
			str=1
	   	}	

	if(str==1)
		return false;
}	


//CODE FOR VALID E-Mail Id


function validate_email(ob) 
{
	emailad=ob.value
	var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
	var check=/@[\w\-]+\./;
	var checkend=/\.[a-zA-Z]{2,3}$/;

	if(((emailad.search(exclude) != -1)||(emailad.search(check)) == -1)||(emailad.search(checkend) == -1))
		return false;
	else 
		return null;


/*	
FOLLOWING IS CODE WE USED EARLIER,NOW WE ARE USING ABOVE CODE

emailad=ob.value
	if(emailad.length>0)
	{
		var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
		var check=/@[\w\-]+\./;
		var checkend=/\.[a-zA-Z]{2,3}$/;

		if(((emailad.search(exclude) != -1)||(emailad.search(check)) == -1)||(emailad.search(checkend) == -1))
			return false;
	
		pattern=/[^@_\.\w\d]|@@|\.\.|__|^@|^\.|^_|@$|\.$|_$|@\.|\.@|@_|_@|\._|_\.|(@)[^@]*\1/g; 
	
		if((((emailad.match(/@/)) && (emailad.match(/\./))) == null) || (emailad.match(pattern) != null))
			return false;
	}
	return null
*/
}

//code for valid username
 
function validate_username(ob)
{		
	s=ob.value
	var str
	bag="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_"
	for (i = 0; i < s.length; i++)
	{   
     	c = s.charAt(i)
		if (bag.indexOf(c) == -1) 
		str=1
	}	
	if(str==1)
		return false;
}

function validate_passportno(ob)
{		

	s=ob.value
	var str
	bag1="ABCDEFGHIJKLMNOPQRSTUVWXYZ"
	char1=s.charAt(0)
	bag="1234567890"
	if(bag1.indexOf(char1)==-1)
		return false

	else
	{
		for (i = 1; i < s.length; i++)
		{   
	     	c = s.charAt(i)
			if (bag.indexOf(c) == -1) 
				str=1
		}
	}	
	if(str==1)
		return false;
}
// code for valid address

function validate_address(ob)
{		
	s=ob.value
	var str
	bag="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_,. "
	for (i = 0; i < s.length; i++)
	{   
     	c = s.charAt(i)
		if (bag.indexOf(c) == -1) 
		str=1
	}	
	if(str==1)
		return false
}

//code for valid username
 
function validate_companyname(ob)
{		
	s=ob.value
	var str
	bag="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-'_()&., "
	for (i = 0; i < s.length; i++)
	{   
     	c = s.charAt(i)
		if (bag.indexOf(c) == -1) 
		str=1
	}	
	if(str==1)
		return false;
}


var flag=0
function validate_password(ob)
{		
	flag=0
	s=ob.value
	var str
	bag1="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
	char1=s.charAt(0)
	if(bag1.indexOf(char1)==-1)
		return false

	bag="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_"
	for (i = 0; i < s.length; i++)
	{   
     	c = s.charAt(i)
		if (bag.indexOf(c) == -1) 
		str=1
	}	
	if(str==1)
		return false;
}

function validate_zipcode(ob)
{	 
	s=ob.value
	str=""
	var str1 = 0;
	bag="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890- "
	for (i = 0;i<s.length;i++)
	{   
    	c = s.charAt(i)
	    if (bag.indexOf(c) == -1) 
			str=1
		if ((isNaN(c) == true) || (c==" "))
			str1++;
			
	}
	if(str==1)
		return false;
}	

function confirmpassword(ob)
{
	if((ob.value!=document.form1.password.value)&&(flag==0))
	{
		ob.value=""
		alert("PASSWORD and CONFIRM PASSWORD do not match")
		document.form1.password.focus()
		return false
	}
}


function isOnlySpaces( obj )
{
    var str = obj.value.toString();
    len = str.length;
    for (i=0;i<len;i++)
    {
       if (str.charAt(i)!=' ')
          return false ;
    }
}


// END OF BOOLEAN FUNCTION

function validate_salary(ob)
{	   
	var str	   	
	s=ob.value
	str=""
	bag="0123456789-,=$.:"
	for (i = 0; i < s.length; i++)
	{   
    	c = s.charAt(i)
	    if (bag.indexOf(c) == -1) 
			str=1
	}
	if(str==1)
		return false
}

function validate_time(ob)
{	   
	var str	   	
	s=ob.value
	str=""
	bag="0123456789.:"
	for (i = 0; i < s.length; i++)
	{   
    	c = s.charAt(i)
	    if (bag.indexOf(c) == -1) 
			str=1
	}
	if(str==1)
		return false
}

function mail(which)
{
	var str=which.value;
	var filter=/^.+@.+\..{2,3}$/;
	
	if (!filter.test(str))
		return false;
}

function getMonthName(mon)
{
	var mname = new Array(12);
	mname[0] = "Jan";
	mname[1] = "Feb";
	mname[2] = "Mar";
	mname[3] = "Apr";
	mname[4] = "May";
	mname[5] = "Jun";
	mname[6] = "Jul";
	mname[7] = "Aug";
	mname[8] = "Sep";
	mname[9] = "Oct";
	mname[10] = "Nov";
	mname[11] = "Dec";
	for(i=0;i<mname.length;i++)
	{
		if(mon == mname[i])
		{
			return i+1;
			break;
		}
	}
}
function checkdate(mm,dd,yy)
{
	if((mm.length!=0) || (dd!=0) || (yy!=0))
	{
		mm = getMonthName(mm);
		dd = parseInt(dd);
		yy = parseInt(yy);
		if ((mm==4) || (mm==6) || (mm==9) || (mm==11))
		{
			if (dd >= 31)
				return false;
		}
		if ( mm==2 )
		{
			if( (yy%4==0 && yy%100 != 0) || (yy%400==0) )
			{
				if (dd>29)
					return false;
			}
			else
			{
				if (dd>28)
					return false;	
			}
		}
	}
	return true;
}

function checkdatediff(mf,df,yf,mt,dt,yt)
{
	if((mf.length!=0) || (df!=1) || (yf!=0) || (mt.length!=0) || (dt!=2) || (yt!=0))
	{
	if((mf.length!=0) || (df!=0) || (yf!=0) || (mt.length!=0) || (dt!=0) || (yt!=0))
	{
	df = parseInt(df);
	dt = parseInt(dt);
	if(yf>yt)
		return false;	
	if(yf==yt)
	{
		mf=getMonthName(mf)
		mt=getMonthName(mt)
//		if(mf<mt)
			return (mt>=mf);
		if(mf==mt)
		{
			if(df>=dt)
				return false;	
		}	
	}
	}
	}
}

function checkBlank(ob)
{
	ob.value = Trim(ob);
	if (ob.value=="")
		return false;
}


function validate_NumSplChars(ob)
{	   
	   	var str	   	
	 	s=ob.value
	 	str=""
	 	if (s.length >4)
	 		str=1
	 		
		bag="0123456789-.,=$:/#()"
		for (i = 0; i < s.length; i++)
	    {   
        	c = s.charAt(i)
	        if (bag.indexOf(c) == -1) 
				str=1
		}
		if(str==1)
		{
			ob.focus()			
			return false
		}
}
