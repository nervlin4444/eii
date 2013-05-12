/** ETimePicker
 *  
 *
 *	author:	Christian Salazar H. <christiansalazarh@gmail.com>
 *	licence: NEW BSD. See licence.
 *	Acarigua, Edo. Portuguesa, Venezuela. Dic2012.
 */
var ETimePicker = function(options){
	function maketime(div){
		var hour = 1 * div.find('input.hour').val();
		var min = 1 * div.find('input.minute').val();
		var ampm = div.find('select').val();
	
		if((hour >= 1) && (hour <= 12)){
			if((min >= 0) && (min <= 59)){
				if((hour == 12) && (ampm == 'am')){
					hour = 0;
				}
				else 
				if((hour != 12) && (ampm == 'pm'))
					hour += 12;
				if(hour < 10) hour = '0'+jQuery.trim(''+hour);
				if(min < 10) min = '0'+jQuery.trim(''+min);
				return jQuery.trim(hour+':'+min);
			}
			else
			return "";
		}
		else
		return "";
	}
	$('div.etimepicker').each(function(){
		var div = $(this);
		var hour = div.find('input.hour');
		var min = div.find('input.minute');
		var ampm = div.find('select');
		var onChange = function(){
			$('#'+$(this).parent().attr('alt')).val(maketime($(this).parent()));
		}
		hour.change(onChange);
		min.change(onChange);
		ampm.change(onChange);
		var fn = function(){
			if(	! (
			  // ((event.keyCode == 190) || (event.keyCode==110)) 	// .
				(event.keyCode == 8) 	// BACKSPACE
			|| ((event.keyCode >= 48) && (event.keyCode <= 57))
			|| ((event.keyCode >= 96) && (event.keyCode <= 105))
			//|| ((event.keyCode == 189) || (event.keyCode == 109)) // -
			|| ((event.keyCode == 37) || (event.keyCode == 39))
			|| ((event.keyCode == 36) || (event.keyCode == 35))
			|| ((event.keyCode == 45) || (event.keyCode == 46))
			|| (event.keyCode == 9)
			))
			{
				event.preventDefault();
				return;
			}
			//else alert(event.keyCode);
		};
		hour.keydown(fn);
		min.keydown(fn);
		var current = jQuery.trim($('#'+div.attr('alt')).val());
		if(jQuery.trim(current).length > 0){
			var h="";
			var m="";
			var s=1;
			var e=0;
			// es una simple maquina de estado finito para leer 
			// la hora presente. Christian Salazar.
			$.each(current, function(i,c){
			if(e==0){
				if(s==1){
					if(	(c=='0') || (c=='1') || (c=='2') || (c=='3') || 
						(c=='4') || (c=='5') || (c=='6') || (c=='7') || 
						(c=='8') || (c=='9')){
						h+=c;
					}
					else
					if(c==':'){
						s=2;
					}
					else
					{ e=1;}
				}else
				if(s==2){
					if(	(c=='0') || (c=='1') || (c=='2') || (c=='3') || 
						(c=='4') || (c=='5') || (c=='6') || (c=='7') || 
						(c=='8') || (c=='9')){
						m+=c;
					}
					else
					{ e=1;}
				}
			}});			
			if(e==0){
				//
				h = 1*h;
				m = 1*m;
				if(((h >= 0) && (h <= 23)) && ((m >= 0) && (m <= 59))){
					var _ampm='am';
					if(h >= 12)
						_ampm='pm';
					if(h == 0)
						h=12;
					if(h > 12)
						h -= 12;
					if(h < 10) h='0'+jQuery.trim(h);
					if(m < 10) m='0'+jQuery.trim(m);
					hour.val(h);
					min.val(m);
					ampm.val(_ampm);
				}
				//
			}
		}
	});
};
