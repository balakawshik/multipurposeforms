
function create_and_append(json_form,container){
	container.html("");
	flag=0;// flag for submittable form
	i=0;
	$.each(json_form,function(n, item){
		required="";

		
		if(item.required){
			required="required";
		}
		if(item.type=="number"){
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><input class='form-control border ' type='"+item.type+"' name='"+i+"' min="+item.min+" max="+item.max+" placeholder='"+item.hint+"' "+required+"></div> ");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="text"){
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><input class='form-control border ' type='"+item.type+"' name='"+i+"' max_length='"+item.max_length+"' placeholder='"+item.hint+"' "+required+"></div> ");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="textarea"){
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><textarea class='form-control border ' type='"+item.type+"' name='"+i+"' min="+item.min+" max="+item.max+" placeholder='"+item.hint+"' "+required+"></textarea></div>");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="date"){
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><input class='form-control border ' type='"+item.type+"' name='"+i+"' min="+item.min+" max="+item.max+"  "+required+"></div>");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="time"){
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><input class='form-control border ' type='"+item.type+"' name='"+i+"' min="+item.min+" max="+item.max+" "+required+"></input></div>");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="range"){
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><input class='form-control border ' type='"+item.type+"' name='"+i+"' min="+item.min+" max="+item.max+" step="+item.step+" "+required+"></input></div>");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="radio"){
			options="";
			$.each(item.options,function(index,option_item){
				if(item.options[index]!=""){
					
					options+="<option value="+item.options[index]+">"+item.options[index]+"</option>";
				}
			});
			
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><select class='form-control border' name='"+i+"' "+required+">"+options+"</select></div>");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="checkbox"){
			options="";
			$.each(item.options,function(index,option_item){
				if(item.options[index]!=""){
					
					options+="<option value="+item.options[index]+">"+item.options[index]+"</option>";
				}
			});
			
			$(container).append("<div class='form-group'><label for='text'> "+item.question+"</label><select multiple class='form-control border' name='"+i+"' "+required+">"+options+"</select></div>");
			console.log(item.type);
			flag=1;
		}
		else if(item.type=="head"){
			$(container).append("<div class='form-group' align='center'><h2>"+item.question+"</h2><p>"+item.description+"</p></div>");
			console.log(item.type);
		}
		else if(item.type=="paragraph"){
			$(container).append("<div class='form-group' align='center'><h4>"+item.question+"</h4><p>"+item.description+"</p></div>");
		}
		i=i+1;
	});
	//input container for user location
	$(container).append("<input type='hidden' id='lat' value='' name='lat'>");
	$(container).append("<input type='hidden' id='lon' value='' name='lon'>");
	$(container).append("<input type='hidden' id='citi' value='' name='citi'>");
	$(container).append("<input type='hidden' id='switched_tab' value='' name='switched_tab'>");
	if(flag){
		$(container).append("<div class='float-right'><input type='submit' class='btn btn-primary' value='Submit' name='submit'></div>");
	}
	//input for user location
	$(container).append(`<script>
	
        $.getJSON("https://api64.ipify.org?format=json", function(data) { 
			url="http://api.ipstack.com/"+data.ip+"?access_key=2a9eb8660a0d3f791416eea5c5f645af&callback=MY_FUNCTION";
			$.get(url, function(response) {
				console.log(response)
				$("#lat").val(response.latitude);
				$("#lon").val(response.longitude);
				$("#citi").val(response.city);
				//count , number of times the tab is switched or application is minimized
				var tab_switch_count=0;
				$("#switched_tab").val(tab_switch_count);
				window.addEventListener('visibilitychange',()=>{
					switch(document.visibilityState){
						case 'hidden':
							tab_switch_count+=1;
							break;
							
					}
					if(tab_switch_count){
						$("#switched_tab").val(tab_switch_count);
					}
				});

			},"jsonp");
		});


	</script>`);
}