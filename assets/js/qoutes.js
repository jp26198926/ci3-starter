function getQoutes() {
    $.get("model/db_qoutes.php",function(data){
        //alert(data);
        if (data.indexOf("Error: ")>-1) {
                     
        }else{                      
            data1 = data.split(":~:|:~:")[0];
            data2 = data.split(":~:|:~:")[1];
            data3 = data.split(":~:|:~:")[2];
                      
            qoutes1 = data1.split(":~|~:")[0];
            author1 = data1.split(":~|~:")[1];
            qoutes2 = data2.split(":~|~:")[0];
            author2 = data2.split(":~|~:")[1];
            qoutes3 = data3.split(":~|~:")[0];
            author3 = data3.split(":~|~:")[1];
                      
            $(".qoutes_msg1").text(qoutes1);
            $(".qoutes_author1").text(author1);
            $(".qoutes_msg2").text(qoutes2);
            $(".qoutes_author2").text(author2);
            $(".qoutes_msg3").text(qoutes3);
            $(".qoutes_author3").text(author3);                      
        }
    });
}  
      
$(document).ready(function(){
    
    $('#quote-carousel').carousel({
        pause: true,
        interval: 4000,
    });
          
    //getQoutes();
          
    setInterval(function() {        
        //getQoutes();
    }, 50000); //5 seconds
          
    //$("#loading").modal();          
});