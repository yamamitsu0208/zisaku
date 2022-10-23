let keyword='';
let music_infos = {};

$('#serch_button').click(function(){
    keyword = $('#serch_keyword').val();
    console.log(keyword);
    $('#serch_keyword').val('');
    $('.result').empty();
    $.ajax({
        url:'https://itunes.apple.com/search',
        type:'GET',
        dataType:'json',
        data:{
            lang: 'ja_jp',
            media: 'music',
            entity:'song',
            country: 'JP',
            term: keyword,
            limit: '20'
        }
    }).done(
        function(data){
            for(let i=0;i<20;i++){
               let music_info ={};
               music_info.artworkUrl = data.results[i].artworkUrl100;
               music_info.artistName = data.results[i].artistName;
               music_info.trackName = data.results[i].trackName;
               music_info.collectionViewUrl = data.results[i].collectionViewUrl;
               music_infos[i] = music_info;
            }
            console.log(music_infos);
            for(let i=0;i<20;i++){
            $('.result').append("<img src=\""+music_infos[i].artworkUrl+"\">");
            $('.result').append("<h3>"+music_infos[i].artistName+"</h3>");
            $('.result').append("<p>"+music_infos[i].trackName+"</p>");
            $('.result').append("<a href=\""+music_infos[i].collectionViewUrl+"\">曲のページへ</a><br>");
            }
        }
    ).fail(
        function(data){
            console.log('失敗しました！');
        }
    );
});
