root = '/poster/';  

  $(document).ready(function() {
    $('.carousel').carousel({
      interval: 5000
    })
  });
  
  $(document).ready(function(){
      $("#location").val('');
      $('#load').click(function(){
          var ne = map.getBounds().getNorthEast();
          var sw = map.getBounds().getSouthWest();

          $.ajax({
          url: 'load.php',
          data: "x1="+sw.lat()+"&y1="+sw.lng()+"&x2="+ne.lat()+"&y2="+ne.lng(),
          complete: function(data){
              var i;
              var output = "";
              var arr = data.responseText.split('#');
              $("#top-k").html(arr[0]);
              var points = JSON.parse(arr[1]);
              for (i = 0; i < points.length; i++) {
                  var marker;
                  output += "P"+(i+1)+"-x:"+points[i][0]+" y:"+points[i][1]+" - "+points[i][2]+"</br>";	
                  
                  var check = 0;
                  for(k=0; k<gmarkers.length; k++){
                      if(gmarkers[k].lat == points[i][0] && gmarkers[k].lng == points[i][1]){
                          //alert(gmarkers[k].getTitle());
                          var title = gmarkers[k].getTitle();
                          var count = gmarkers[k].count;
                          count += 1;
                          gmarkers[k].count = count;
                          gmarkers[k].setTitle(title+"\n-"+points[i][4]);
                          gmarkers[k].setIcon('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+count+'|2554C7|FFFFFF');
                          check = 1;
                      }
                  }
                  if(check == 0){
                    marker = new google.maps.Marker({
                          position: new google.maps.LatLng(points[i][0], points[i][1]),
                          map: map,
                          title: '-'+points[i][4],
                          content: points[i][4],
                          icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    });
                    marker.lat = points[i][0];
                    marker.lng = points[i][1];
                    marker.count = 1;
                    google.maps.event.addListener(marker, 'click', function(){
                       var res = this.getTitle().split("\n");
                       var comment = '';
                       for(m=0; m< res.length; m++){
                         comment += res[m]+'</br>';
                       }
                       $("#marker").html('<div class="bs-callout bs-callout-info"> <h4>Comment</h4> <p>'+comment+'</p> </div>');
                    });
                    gmarkers.push(marker);
                  }
                  
              }
              
              
              var data = [];
              var j=0;
              var current = 0;
              var check = 0;
              while(j < points.length)  {
                if(parseInt(points[j][2]) == current){
                  //alert(points[i][2]);
                  data.push(new google.maps.LatLng(points[j][0] , points[j][1]));
                  if(points.length == (j+1)){
                    check = 1;
                  }
                }
                else{
                  current = parseInt(points[j][2]);
                  
                  if(j>0){
                    check = 1;                    
                  }
                  else{
                    data.push(new google.maps.LatLng(points[j][0] , points[j][1]));
                  }
                }
                if(check == 1){
                  //alert(data.length);
                  if(data.length > 1){
                    var polyline = new google.maps.Polyline({
                        path: data,
                        strokeColor: '#0000FF',
                        strokeOpacity: 1.0,
                        strokeWeight: 2,
                        editable: false
                    });
                    polyline.setMap(map);
                    //alert(data.length);
                    
                  } 
                  data.length = 0;
                    //alert(data.length);
                  data.push(new google.maps.LatLng(points[j][0] , points[j][1]));
                  check = 0;
                }
                //alert("Current:"+current);
                j++;
              }   
                         
              
              $('#points').html(output);
          }
      }); 
  });	 
});

$(document).ready(function(){
      $('#search').click(function(){
        var keyword = ""; 
        first = 1;
        counter = 1;
        $('input', $('#trajectory')).each(function () {
            if(first == 1){
                first = 0;
                keyword += this.value;
                counter++;
            }
            else{
                keyword += ';'+this.value;
                counter++;
            }
             //log every element found to console output
        });
          
          $.ajax({
          method: "POST",
          url: 'algorithm.php',
          data: "result="+$('#result').val()+"&algorithm="+$("input:radio[name=algorithm]:checked" ).val()+"&keywords="+keyword+"&locations="+$('#location').val(),
          complete: function(data){
              $('#points').html(data.responseText);
          }
          
          });
          
  });	 
});

$(document).ready(function(){
  $('#trajectory').on('click', '#remove', function (){
      
      $(this).parent().parent().remove();
      var info = $(this).parent().html();
      var lat = info.split(" ")[1];
      var lng = info.split(" ")[3];
      var tmp = []; 
      trajectory.setMap(null);
      for(var i = 0; i < data.length; i++) {
          if(data[i].lat() != lat || data[i].lng() != lng){
            tmp.push(data[i]);
          }
          
      }
      for(var i = 0; i < tmarkers.length; i++) {
          if(tmarkers[i].getPosition().lat() == lat && tmarkers[i].getPosition().lng() == lng){
            tmarkers[i].setMap(null);
          } 
      }
      data = tmp;
      if(data.length > 1){
        if(trajectory != null){
            trajectory.setMap(null);
        }
        trajectory = new google.maps.Polyline({
            path: data,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2,
            editable: false
        });
        trajectory.setMap(map);
      }
    
    
  });
  
});

$(document).ready(function(){
  $('#top-k').on('click', 'img', function (){
      
    if($(this).attr("record")){
      $.ajax({
        method: "POST",
        url: 'photo.php',
        data: "user="+$(this).attr("user")+"&record="+$(this).attr("record"),
        complete: function(data){
            var arr = data.responseText.split("#");
            $('#carousel-photo').html(arr[1]);
            $('#full-list').html(arr[0]);
            var jcarousel = $('.jcarousel').jcarousel();
            jcarousel.jcarousel('reload');
            jcarousel.jcarousel('scroll', '0');
        }

      });  
    }     
    
  });
  
});