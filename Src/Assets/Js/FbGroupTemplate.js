
function decorateFbSite(group){

    html = '<div class="col-md-12">\n' +
        '        <div class="panel panel-default">\n' +
        '            <div class="panel-body">\n' +
        '               <section class="post-heading">\n' +
        '                    <div class="row">\n' +
        '                        <div class="col-md-11">\n' +
        '                            <div class="media">\n' +
        '                              <div class="media-left">\n' +
        '                                <a href="?page_id=' + group.id + '">\n' +
        '                                  <img class="media-object photo-profile" src="https://graph.facebook.com/' + group.id + '/picture?type=square" width="40" height="40" alt="...">\n' +
        '                                </a>\n' +
        '                              </div>\n' +
        '                              <div class="media-body">\n' +
        '                                <a href="?page_id=' + group.id + '" class="anchor-username"><h4 class="media-heading">' + group.name + '</h4></a> \n' +
        '                                <a href="?page_id=' + group.id + '"" class="anchor-time">' + group.category + '</a>\n' +
        '                              </div>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                         <div class="col-md-1">\n' +
        '                             <a href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>\n' +
        '                         </div>\n' +
        '                    </div>             \n' +
        '               </section>\n' +
        '               <section class="post-body">\n' +
        '                   <ul>';
    (group.tasks).forEach(function (task,key) {
        html += '<li>';
        html += '<span class="alert alert-primary">' + task + '</span>';
        html += '</li>';
    });
        '               </ul>\n' +
        '               </section>\n' +
        '               <section class="post-footer">\n' +
        '                   <hr>\n' +
        '                   <div class="post-footer-option container">\n' +
        '                        <ul class="list-unstyled">\n' +
        '                            <li><a href="#"><i class="alert alert-success glyphicon glyphicon-thumbs-up"></i> Vybrat ke sdílení</a></li>\n' +
        '                            <li><a href="#"><i class="alert alert-warning glyphicon glyphicon-comment"></i> Označit poznámkou</a></li>\n' +
        '                            <li><a href="#"><i class="alert alert-danger glyphicon glyphicon-remove"></i> Odebrat ze seznamu</a></li>\n' +
        '                        </ul>\n' +
        '                   </div>\n' +
        '               </section>\n' +
        '            </div>\n' +
        '        </div>   \n' +
        '\t</div>';

    return html;

}

function getGroupFeed(id){
        console.log('Getting group feed.... ');

        FB.api(id+'/feed', function (response) {
            console.log(response);
            data = response.data;
            $.each(data, function (key, value) {
                $('#groupFeed_'+id).append('<li><small>' + value.updated_time + '</small><strong>' + value.story + ':</strong> ' + value.message + ' </li>');
            });
        });

}