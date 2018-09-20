//selec all files
function selectAllFiles(){
	jQuery("input:checkbox").prop("checked", "checked");
}

//deselect all files
function deselectAllFiles(){
	jQuery("input:checkbox").prop("checked", "");
}

//delete selected files
function deleteSelectedFiles(pathToActionFile, directory, ftpServer, ftpUser, ftpPassword, resources){
	
	if(jQuery('input:checkbox:checked.selected_files').length > 0){

		var confirm = window.confirm("Are you really want to delete the selected files?");
		if(confirm){
			jQuery('input:checkbox:checked.selected_files').each(function(){  
				deleteFile(pathToActionFile, directory, jQuery(this).val(), ftpServer, ftpUser, ftpPassword, resources, 0)
			});
		}
	}
	else
		alert("No File Selected!");
}

//delete single file
function deleteFile(pathToActionFile, directory, filename, ftpServer, ftpUser, ftpPassword, resources, force){

	if(force==1)
		var confirm = window.confirm("Are you really want to delete this file?");
	else
		var confirm = true;

	if(confirm){
		jQuery.ajax({
		    type: "POST",
		    url: pathToActionFile,
		    data: {user: directory, ism: filename, ftpserver:ftpServer , ftpuser:ftpUser , ftppassword:ftpPassword},
		    beforeSend: function(){
		    	jQuery(".files-list-table").html("<div class='loading'><img src='"+resources+"/img/ajax-loader.gif'></div>");
		   },
		    success: function(data){
		    	console.log(data);
		    },
		    error: function (jqXHR, exception) {
		    	var msg = '';
		        if (jqXHR.status === 0) {
		            msg = 'Not connect.\n Verify Network.';
		        } else if (jqXHR.status == 404) {
		            msg = 'Requested page not found. [404]';
		        } else if (jqXHR.status == 500) {
		            msg = 'Internal Server Error [500].';
		        } else if (exception === 'parsererror') {
		            msg = 'Requested JSON parse failed.';
		        } else if (exception === 'timeout') {
		            msg = 'Time out error.';
		        } else if (exception === 'abort') {
		            msg = 'Ajax request aborted.';
		        } else {
		            msg = 'Uncaught Error.\n' + jqXHR.responseText;
		        }
		        alert(msg);
		    }
		}).done(function() {
			jQuery(".files-list-table").fadeOut(800, function(){
            	jQuery(".files-list-table").load(location.href + " .files-list-table > *").fadeIn().delay(2000);
             });
		});
	}
}

//rename single file
function renameFile(pathToActionFile, directory, filename, ftpServer, ftpUser, ftpPassword, resources){

	var newName = prompt("Please enter new name", filename);

	if(newName!=null){
		jQuery.ajax({
		    type: "POST",
		    url: pathToActionFile,
		    data: {user: directory, ism: filename, ismn: newName, ftpserver:ftpServer , ftpuser:ftpUser , ftppassword:ftpPassword},
		    beforeSend: function(){
		    	jQuery(".files-list-table").html("<div class='loading'><img src='"+resources+"/img/ajax-loader.gif'></div>");
		   },
		    success: function(data){
		    	console.log(data);
		    },
		    error: function (jqXHR, exception) {
		    	var msg = '';
		        if (jqXHR.status === 0) {
		            msg = 'Not connect.\n Verify Network.';
		        } else if (jqXHR.status == 404) {
		            msg = 'Requested page not found. [404]';
		        } else if (jqXHR.status == 500) {
		            msg = 'Internal Server Error [500].';
		        } else if (exception === 'parsererror') {
		            msg = 'Requested JSON parse failed.';
		        } else if (exception === 'timeout') {
		            msg = 'Time out error.';
		        } else if (exception === 'abort') {
		            msg = 'Ajax request aborted.';
		        } else {
		            msg = 'Uncaught Error.\n' + jqXHR.responseText;
		        }
		        alert(msg);
		    }
		}).done(function() {
			jQuery(".files-list-table").fadeOut(800, function(){
            	jQuery(".files-list-table").load(location.href + " .files-list-table > *").fadeIn().delay(2000);
             });
		});
	}
}

































