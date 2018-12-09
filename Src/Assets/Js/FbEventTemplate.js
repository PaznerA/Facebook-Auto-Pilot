
function decorateFbEvent(event){

    html = '<div class="col-md-12">\n' +
        '        <div class="panel panel-default">\n' +
        '            <div class="panel-body">\n' +
        '               <section class="post-heading">\n' +
        '                    <div class="row">\n' +
        '                        <div class="col-md-11">\n' +
        '                            <div class="media">\n' +
        '                              <div class="media-left">\n' +
        '                                <a href="#">\n' +
        '                                  <img class="media-object photo-profile" src="https://graph.facebook.com/' + event.id + '/picture?type=square" width="40" height="40" alt="...">\n' +
        '                                </a>\n' +
        '                              </div>\n' +
        '                              <div class="media-body">\n' +
        '                                <a href="#" class="anchor-username"><h4 class="media-heading">' + event.name + '</h4></a> \n' +
        '                                <a href="#" class="anchor-time">' + event.place.name + '</a>\n' +
        '                              </div>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                         <div class="col-md-1">\n' +
        '                             <a href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>\n' +
        '                         </div>\n' +
        '                    </div>             \n' +
        '               </section>\n' +
        '               <section class="post-body">\n' +
        '                   <p>' + event.description + ' \n' +
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
        '                   <div class="post-footer-comment-wrapper">\n' +
        '                       <div class="comment-form">\n' +
        '                           \n' +
        '                       </div>\n' +
        '                       <div class="comment">\n' +
        '                            <div class="media">\n' +
        '                            ' + event.start_time + ' - ' + event.end_time +
        '                            </div>\n' +
        '                       </div>\n' +
        '                   </div>\n' +
        '               </section>\n' +
        '            </div>\n' +
        '        </div>   \n' +
        '\t</div>';

    return html;

}