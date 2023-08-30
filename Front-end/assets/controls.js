class VectorControls extends ol.control.Control {
  constructor(opt_options) {
    const options = opt_options || {};

    const controls_container = document.createElement("div");
    controls_container.classList.add("layers_controls", "border-bottom-0", "rounded-top", "ps-1", "ol-unselectable", "ol-control");

    const form_check_rack = document.createElement("div");
    form_check_rack.classList.add("form-check", "form-check-inline");

    const form_check_poi = form_check_rack.cloneNode();
    const form_check_forbidden = form_check_rack.cloneNode();
    
    const inputRack = document.createElement("input");
    inputRack.classList.add("form-check-input");
    inputRack.setAttribute("type", "checkbox");
    inputRack.setAttribute("name", "racks");
    inputRack.onclick = setRacks;

    const labelRack = document.createElement("label");
    labelRack.classList.add("form-check-label");
    const labelRack_text = document.createTextNode("Rastrelliere");

    const inputPOI = document.createElement("input");
    inputPOI.classList.add("form-check-input");
    inputPOI.setAttribute("type", "checkbox");
    inputPOI.setAttribute("name", "poi");
    inputPOI.onclick = setPOI;

    const labelPOI = document.createElement("label");
    labelPOI.classList.add("form-check-label");
    const labelPOI_text = document.createTextNode("POI");

    const inputForbidden = document.createElement("input");
    inputForbidden.classList.add("form-check-input");
    inputForbidden.setAttribute("type", "checkbox");
    inputForbidden.setAttribute("name", "forbidden");
    inputForbidden.onclick = setForbidden;

    const labelForbidden = document.createElement("label");
    labelForbidden.classList.add("form-check-label");
    const labelForbidden_text = document.createTextNode("Aree vietate");

    form_check_rack.appendChild(inputRack);
    form_check_rack.appendChild(labelRack);
    labelRack.appendChild(labelRack_text);

    form_check_poi.appendChild(inputPOI);
    form_check_poi.appendChild(labelPOI);
    labelPOI.appendChild(labelPOI_text);

    form_check_forbidden.appendChild(inputForbidden);
    form_check_forbidden.appendChild(labelForbidden);
    labelForbidden.appendChild(labelForbidden_text);

    controls_container.appendChild(form_check_rack);
    controls_container.appendChild(form_check_poi);
    controls_container.appendChild(form_check_forbidden);

    super({
      element: controls_container,
      target: options.target,
    });

  }
}

class Legend extends ol.control.Control {
  constructor(opt_options) {
    const options = opt_options || {};

    const controls_container = document.createElement("div");
    controls_container.classList.add("legend","ol-unselectable", "ol-control");

    const legendList = document.createElement("ul");

    const li = document.createElement("li");
    li.classList.add("d-flex", "align-items-center", "text_legend");

    const img_circle = document.createElement("span");
    img_circle.classList.add("circle_legend");
    const img_square = document.createElement("span");
    img_square.classList.add("square_legend");

    const li_avBike = li.cloneNode();
    const avBike_img = img_circle.cloneNode();
    avBike_img.style.backgroundColor = "blue";
    li_avBike.textContent = "Bici disponibile";
    li_avBike.insertBefore(avBike_img, li_avBike.firstChild);

    const li_movingBike = li.cloneNode();
    const movingBike_img = img_circle.cloneNode();
    movingBike_img.style.backgroundColor = "red";
    li_movingBike.textContent = "Bici in uso";
    li_movingBike.insertBefore(movingBike_img, li_movingBike.firstChild);

    const li_outsideBike = li.cloneNode();
    const outsideBike_img = img_circle.cloneNode();
    outsideBike_img.style.backgroundColor = "purple";
    li_outsideBike.textContent = "Bici fuori area servizio";
    li_outsideBike.insertBefore(outsideBike_img, li_outsideBike.firstChild);

    const li_selectedBike = li.cloneNode();
    const selectedBike_img = img_circle.cloneNode();
    selectedBike_img.style.backgroundColor = "transparent";
    selectedBike_img.style.border = "2px solid #cc33ff";
    li_selectedBike.textContent = "Bici selezionata";
    li_selectedBike.insertBefore(selectedBike_img, li_selectedBike.firstChild);

    legendList.appendChild(li_avBike);
    legendList.appendChild(li_movingBike);
    legendList.appendChild(li_outsideBike);
    legendList.appendChild(li_selectedBike);

    var line_break_div = document.createElement("div");
    line_break_div.classList.add("lh-1");
    line_break_div.appendChild(document.createElement("br"));
    legendList.appendChild(line_break_div);

    const li_POI = li.cloneNode();
    const POI_img = img_square.cloneNode();
    POI_img.style.backgroundColor = "rgba(34, 167, 240, 0.4)";
    POI_img.style.border = "1px solid rgba(34, 167, 240, 1)";
    li_POI.textContent = "POI";
    li_POI.insertBefore(POI_img, li_POI.firstChild);

    const li_forbidden = li.cloneNode();
    const forbidden_img = img_square.cloneNode();
    forbidden_img.style.backgroundColor = "rgba(255, 0, 0, 0.4)";
    forbidden_img.style.border = "1px solid rgba(255, 0, 0, 1)";
    li_forbidden.textContent = "Area vietata";
    li_forbidden.insertBefore(forbidden_img, li_forbidden.firstChild);

    legendList.appendChild(li_POI);
    legendList.appendChild(li_forbidden);

    var second_line_break_div = line_break_div.cloneNode();
    second_line_break_div.appendChild(document.createElement("br"));
    legendList.appendChild(second_line_break_div);

    // Checkbox Geofence density

    const form_check_density = document.createElement("div");
    form_check_density.classList.add("form-check", "form-check-legend");
    const checkbox = document.createElement("input");
    checkbox.classList.add("form-check-input");
    const labelCheckbox = document.createElement("label");
    labelCheckbox.classList.add("form-check-label");

    const form_POI_density = form_check_density.cloneNode();
    const checkbox_POI_density = checkbox.cloneNode();
    checkbox_POI_density.setAttribute("type", "checkbox");
    checkbox_POI_density.setAttribute("name", "poi_density");
    checkbox_POI_density.onclick = setPOI_density;
    const label_POI_density = labelCheckbox.cloneNode();
    label_POI_density.textContent = "POIs Ingressi";

    form_POI_density.appendChild(checkbox_POI_density);
    form_POI_density.appendChild(label_POI_density);
    legendList.appendChild(form_POI_density);

    const img_list = document.createElement("ul");
    img_list.classList.add("d-none");
    const img = document.createElement("img");
    img.classList.add("img_legend");

    const ul_poi = img_list.cloneNode();
    ul_poi.setAttribute("id", "ul_poi");

    var max_poi = 0;
    var distinct_entries = [];
    json_poi_density_0["features"].forEach(el => {
      let entries = parseInt(el["properties"]["entries"]);
      if(!distinct_entries.includes(entries)) {
        distinct_entries.push(entries);
        max_poi += 1;
      }
    });

    for(var i = 0; i < max_poi; i++) {
      let li_poi = li.cloneNode();
      let img_poi = img.cloneNode();
      img_poi.setAttribute("src", "qgis/styles/legend/poi_density_0_" + String(i) + ".png");
      li_poi.textContent = String(i);
      li_poi.insertBefore(img_poi, li_poi.firstChild)
      ul_poi.appendChild(li_poi);
    }
    legendList.appendChild(ul_poi);

    const form_Forbidden_density = form_check_density.cloneNode();
    const checkbox_Forbidden_density = checkbox.cloneNode();
    checkbox_Forbidden_density.setAttribute("type", "checkbox");
    checkbox_Forbidden_density.setAttribute("name", "forbidden_density");
    checkbox_Forbidden_density.onclick = setForbidden_density;
    const label_Forbidden_density = labelCheckbox.cloneNode();
    label_Forbidden_density.textContent = "Aree Vietate Ingressi";

    form_Forbidden_density.appendChild(checkbox_Forbidden_density);
    form_Forbidden_density.appendChild(label_Forbidden_density);
    legendList.appendChild(form_Forbidden_density);

    const ul_forbidden = img_list.cloneNode();
    ul_forbidden.setAttribute("id", "ul_forbidden");

    var max_fa = 0;
    var distinct_entries = [];
    json_fa_density_1["features"].forEach(el => {
      let entries = parseInt(el["properties"]["entries"]);
      if(!distinct_entries.includes(entries)) {
        distinct_entries.push(entries);
        max_fa += 1;
      }
    });

    for(var i = 0; i < max_fa; i++) {
      let li_fa = li.cloneNode();
      let img_fa = img.cloneNode();
      img_fa.setAttribute("src", "qgis/styles/legend/fa_density_1_" + String(i) + ".png");
      li_fa.textContent = String(i);
      li_fa.insertBefore(img_fa, li_fa.firstChild)
      ul_forbidden.appendChild(li_fa);
    }
    legendList.appendChild(ul_forbidden);

    // KMeans

    var max_cluster = 0;
    json_kmeans_2["features"].forEach(el => {
      var cluster_id = parseInt(el["properties"]["CLUSTER_ID"]);
      if(cluster_id > max_cluster) {
        max_cluster = cluster_id
      }
    });

    const form_kmeans = form_check_density.cloneNode();
    const checkbox_kmeans = checkbox.cloneNode();
    checkbox_kmeans.setAttribute("type", "checkbox");
    checkbox_kmeans.setAttribute("name", "kmeans");
    checkbox_kmeans.onclick = setKMeans;
    const label_kmeans = labelCheckbox.cloneNode();
    label_kmeans.textContent = "KMeans";

    form_kmeans.appendChild(checkbox_kmeans);
    form_kmeans.appendChild(label_kmeans);
    legendList.appendChild(form_kmeans);

    const ul_kmeans = img_list.cloneNode();
    ul_kmeans.setAttribute("id", "ul_kmeans");

    for(var i = 0; i <= max_cluster; i++) {
      let li_kmeans = li.cloneNode();
      let img_kmeans = img.cloneNode();
      img_kmeans.setAttribute("src", "qgis/styles/legend/kmeans_2_" + String(i) + ".png");
      img_kmeans.style.width = "30px";
      img_kmeans.style.height = "30px";
      li_kmeans.textContent = String(i);
      li_kmeans.insertBefore(img_kmeans, li_kmeans.firstChild)
      ul_kmeans.appendChild(li_kmeans);
    }
    legendList.appendChild(ul_kmeans);


    controls_container.appendChild(legendList);

    super({
      element: controls_container,
      target: options.target,
    });

  }
}