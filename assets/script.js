$(document).ready(function(){
    $(".your_ans ").click(function(){
        post_id=$(this).attr("data-id");
        $(".glob_form_"+post_id).toggle();
    })
})