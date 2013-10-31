$(document).ready(function(){

	$("#sectionDropdown").change(function(){
		location.href=window.location.pathname+"?section="+$(this).val();
	});
	
	$("#addButton").click(showAddForm);
	
	$("textarea").each(function(){
		$(this).keyup(function(){
			if($(this).val().length>=parseInt($(this).attr('maxlength')))
			{
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
		});
	});
	
});

function showAddForm()
{
	$("#addForm").slideDown();
	$(this).val("Collapse Add Form");
	$(this).unbind('click');
	$(this).click(hideAddForm);
}

function hideAddForm()
{
	$("#addForm").slideUp();
	$(this).val("Show Add Form");
	$(this).unbind('click');
	$(this).click(showAddForm);
}