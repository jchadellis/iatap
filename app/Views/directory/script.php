<script>$(document).ready(function(){
    var search = $('#searchInput'); 
    var form = $('#searchForm');
    let timer; 
    $(search).keyup(function(event){
        clearTimeout(timer); 
        timer = setTimeout(() => {
             $.post('http://connectportal/index.php/directory/search', {'search' : $(search).val() }, function(response){
                if(response)
                {
                    $('#contacts').html(response);
                }
             });
        }, 500);
       
    })
})
</script>;
