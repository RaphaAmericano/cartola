(function( $ ){
    alert('Funciona');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'consultas.php',
        data: {
            action: 'carregarGraficos'
        }, success: function(response){
            alert(response);
        }, error: function(err, err2, err3){
            console.log(err+' '+err2+' '+err3);
        }
    })

}( jQuery ));