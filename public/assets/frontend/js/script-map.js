var width =  document.getElementById('box-map').offsetWidth,
    height = document.getElementById('box-map').offsetHeight,
    centered;

var colorRange = ["red", "#ffc499", "#ffad72", "#ff9f5b", "#ff8e3e", "#fb6900", "#d45800", "#933d00", "#662b00"];

var ipm = d3.map();

var averageIPM = 0;

var color = d3.scaleThreshold()
    .domain(d3.range(2,10))
    .range(colorRange);

var projection = d3.geoEquirectangular()
        .scale(1050)
        .rotate([-120, 0])
        .translate([width / 2, height / 2]);

var path = d3.geoPath()
    .projection(projection);

var svg = d3.select("#box-map").insert("svg")
            .attr("width", width)
            .attr("height", height * 0.8)
            .attr("class", "map");
    
svg.append("rect")
    .attr("class", "background")
    .attr("width", width)
    .attr("height", height)
    .on("click", clicked);

var g = svg.append("g");

var x = d3.scaleLinear()
    .domain([1, 10])
    .rangeRound([600, 860]);

g.selectAll("rect")
  .data(color.range().map(function(d) {
      d = color.invertExtent(d);
      if (d[0] == null) d[0] = x.domain()[0];
      if (d[1] == null) d[1] = x.domain()[1];
      return d;
    }))
  .enter().append("rect")
    .attr("height", 8)
    .attr("x", function(d) { return x(d[0]); })
    .attr("width", function(d) { return x(d[1]) - x(d[0]); })
    .attr("fill", function(d) { return color(d[0]); });

g.append("text")
    .attr("class", "caption")
    .attr("x", x.range()[0])
    .attr("y", 60)
    .attr("fill", "#000")
    .attr("text-anchor", "start")
    .attr("font-weight", "bold")
    .text("Human Development Index : Indonesia");

g.call(d3.axisBottom(x)
    .tickSize(13)
    .tickFormat(function(x, i) { return x + "0"; })
    .tickValues(color.domain()))
    .select(".domain")
    .remove();
//*

d3.queue()
  .defer(d3.json,"../data/IDN.json")
  .defer(d3.csv,"../data/ipm.csv", function(d) {
    ipm.set(d.nama_kabkota, Number(d.ipm/10));
  })
  .await(ready);

function ready(error, data) {
  if (error) throw error;

  // Calculate Average IPM
  ipm.each(function(d) {
    averageIPM += Number(d)*10;
  });
  averageIPM = (averageIPM/ipm.size()).toPrecision(4);

  document.getElementById('info-details').innerHTML = "Human Development Index (Average) : " + averageIPM;

  g.append("g")
      .attr("id", "subunits")
      .selectAll("path")
      .data(topojson.feature(data, data.objects.IDN_adm_2_kabkota).features)
      .enter().append("path")
      .attr("fill", function(d) {
        var key = d.properties.NAME_2;
        key = (d.properties.VARNAME_2) ? d.properties.VARNAME_2 : key;
        if(!ipm.get(key)) key = d.properties.NAME_2;
        if(!ipm.get(key)) console.log(d.properties.VARNAME_2,key);

        return color(d.ipm = ipm.get(key))
      })
      .attr("d", path)
      .text(function(d) { return d.ipm + "%"; })
      .on("click", clicked);

  g.append("path")
      .datum(topojson.mesh(data, data.objects.IDN_adm_2_kabkota, function(a, b) { return a !== b; }))
      .attr("id", "state-borders")
      .attr("d", path);
};

function regionName(region) {

  return region.properties.NAME_1.toUpperCase() +" : "+ region.properties.NAME_2.toUpperCase();
}

function getHDI(region) {
  var key = region.properties.NAME_2;
  if(ipm.get(key)) return (ipm.get(key)*10).toPrecision(4);
  key = region.properties.VARNAME_2;
  if(ipm.get(key)) return (ipm.get(key)*10).toPrecision(4);

  return "no data";
}

function clicked(d) {
  var x, y, k;

  if(d) {
    console.log(d.properties);
    document.getElementById('info-location').innerHTML = regionName(d);
    document.getElementById('info-details').innerHTML = "Human Development Index : " + getHDI(d);
  } else {
    document.getElementById('info-location').innerHTML = "INDONESIA";
    document.getElementById('info-details').innerHTML = "Human Development Index (Average) : " + averageIPM;
  }

  if (d && centered !== d) {
    var centroid = path.centroid(d);
    x = centroid[0];
    y = centroid[1];
    k = 4;
    centered = d;
  } else {
    x = width / 2;
    y = height / 2;
    k = 1;
    centered = null;
  }

  g.selectAll("path")
      .classed("active", centered && function(d) { return d === centered; });

  g.transition()
      .duration(750)
      .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")")
      .style("stroke-width", 1.5 / k + "px");
}