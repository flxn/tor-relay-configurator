var presets = {
  "relay": {
    "relayname": "",
    "contactinfo": "",
    "trc-track": true,
    "orport": 9001,
    "dirport": 9030
  },
  "bridge": {
    "relayname": null,
    "contactinfo": null,
    "trc-track": null,
    "orport": "auto",
    "dirport": null
  },
  "exit": {
    "relayname": "",
    "contactinfo": "",
    "trc-track": true,
    "orport": 9001,
    "dirport": 80
  }
}

$('input[name=node-type]').change(function() {
  var selectedType = $('input[name=node-type]:checked').val();
  if(selectedType == 'exit') {
    $('#exit-info').fadeIn(150);
  } else {
    $('#exit-info').fadeOut(150);
  }

  var preset = presets[selectedType];
  for (var presetKey in preset) {
    if (preset.hasOwnProperty(presetKey)) {
      var presetValue = preset[presetKey];
      $('#field-' + presetKey + ' input').parent().fadeIn(150);
      if(presetValue === null) {
        $('#field-' + presetKey + ' input').parent().fadeOut(150);
      } else {
        $('#field-' + presetKey + ' input').val(presetValue);
      }

    }
  }
});

$('#exit-info').hide();

$('.only-numbers').keyup(function() {
    $(this).val($(this).val().replace(/\D/g,''));
});

$(function() {
  var nodesChart = new Chart("chartNodes", {
      type: 'line',
      data: {
        datasets: [{
          label: "nodes",
          data: nodesChartData
        }]
      },
      options: {
        responsive: true,
        title:      {
            display: true,
            text:    "# Nodes",
        },
        legend: {
          display: false
        },
        elements: {
          point: {
            radius: 0
          }
        },
        animation: {
          duration: 0,
        },
        hover: {
            animationDuration: 0,
        },
        responsiveAnimationDuration: 0,
        scales:     {
            xAxes: [{
                type: "time",
                time:       {
                  unit:'day',
                    tooltipFormat: 'll',
                  
                },
                scaleLabel: {
                    display:     false,
                    labelString: 'Date'
                }
            }],
            yAxes: [{
                scaleLabel: {
                    display:     false,
                    labelString: 'Nodes'
                },
                ticks: {
                  beginAtZero: true
              }
            }]
        }
    }
  });
  var bandwidthChart = new Chart("chartBandwidth", {
    type: 'line',
    data: {
      datasets: [{
        label: "Bandwidth",
        data: bandwidthChartData
      }]
    },
    options: {
      responsive: true,
      title:      {
          display: true,
          text:    "Bandwidth (Mb/s)"
      },
      legend: {
        display: false
      },
      elements: {
        point: {
          radius: 0
        }
      },
      animation: {
        duration: 0,
      },
      hover: {
          animationDuration: 0,
      },
      responsiveAnimationDuration: 0,
      scales:     {
          xAxes: [{
              type: "time",
              time:       {
                unit:'day',
                  tooltipFormat: 'll',
                
              },
              scaleLabel: {
                  display:     false,
                  labelString: 'Date'
              }
          }],
          yAxes: [{
              scaleLabel: {
                  display:     false,
                  labelString: 'Mb/s'
              },
              ticks: {
                beginAtZero: true
            }
          }]
      }
  }
});
});