/**
 * processData.js
 * Created by robertlanter on 5/15/14.
 *
 * Generic routine to submit client requests to server.
 * input: list of parameters,  a url string, and an identifier used in the calling code to parse the JSON response object returned
 */
function processData(param_string, url, identifier) {
    var params = param_string;
    var xmlhttp;
    var response;

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url, false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState != 4)  { return; }
        if (xmlhttp.status != 200)  {
            return xmlhttp.status;
        }
    }

    xmlhttp.send(params);
    response = xmlhttp.responseText;

    localStorage.setItem(identifier, response);
    return xmlhttp.status;
}

