$(document).ready(function(){
    (function () {
        // Get relevant elements and collections
        const tabbed = document.querySelector('.tabbed');
        const tablist = tabbed.querySelector('ul');
        const tabs = tablist.querySelectorAll('a');
        const panels = tabbed.querySelectorAll('[id^="section"]');
      
        // The tab switching function
        const switchTab = (oldTab, newTab) => {
          newTab.focus();
          // Make the active tab focusable by the user (Tab key)
          newTab.removeAttribute('tabindex');
          // Set the selected state
          newTab.setAttribute('aria-selected', 'true');
          oldTab.removeAttribute('aria-selected');
          oldTab.setAttribute('tabindex', '-1');
          // Get the indices of the new and old tabs to find the correct
          // tab panels to show and hide
          let index = Array.prototype.indexOf.call(tabs, newTab);
          let oldIndex = Array.prototype.indexOf.call(tabs, oldTab);
          panels[oldIndex].hidden = true;
          panels[index].hidden = false;
        };
      
        // Add the tablist role to the first <ul> in the .tabbed container
        tablist.setAttribute('role', 'tablist');
      
        // Add semantics are remove user focusability for each tab
        Array.prototype.forEach.call(tabs, (tab, i) => {
          tab.setAttribute('role', 'tab');
          tab.setAttribute('id', 'tab' + (i + 1));
          tab.setAttribute('tabindex', '-1');
          tab.parentNode.setAttribute('role', 'presentation');
      
          // Handle clicking of tabs for mouse users
          tab.addEventListener('click', e => {
            e.preventDefault();
            let currentTab = tablist.querySelector('[aria-selected]');
            if (e.currentTarget !== currentTab) {
              switchTab(currentTab, e.currentTarget);
            }
          });
      
          // Handle keydown events for keyboard users
          tab.addEventListener('keydown', e => {
            // Get the index of the current tab in the tabs node list
            let index = Array.prototype.indexOf.call(tabs, e.currentTarget);
            // Work out which key the user is pressing and
            // Calculate the new tab's index where appropriate
            let dir = e.which === 37 ? index - 1 : e.which === 39 ? index + 1 : e.which === 40 ? 'down' : null;
            if (dir !== null) {
              e.preventDefault();
              // If the down key is pressed, move focus to the open panel,
              // otherwise switch to the adjacent tab
              dir === 'down' ? panels[i].focus() : tabs[dir] ? switchTab(e.currentTarget, tabs[dir]) : void 0;
            }
          });
        });
      
        // Add tab panel semantics and hide them all
        Array.prototype.forEach.call(panels, (panel, i) => {
          panel.setAttribute('role', 'tabpanel');
          panel.setAttribute('tabindex', '-1');
          let id = panel.getAttribute('id');
          panel.setAttribute('aria-labelledby', tabs[i].id);
          panel.hidden = true;
        });
      
        // Initially activate the first tab and reveal the first tab panel
        tabs[0].removeAttribute('tabindex');
        tabs[0].setAttribute('aria-selected', 'true');
        panels[0].hidden = false;
      })();


      $('#create-open-ship').on('submit', function(event){
          $url = $(this).attr('data-action');
        $input = JSON.stringify({
            'index': "Test1234",
            'requestedShipment': {
                'shipper':{
                    'contact': {
                        'personName':$('input[name="shipper_personName"]').val(),
                        'phoneNumber':$('input[name="shipper_phoneNumber"]').val(),
                    },
                    'address':{
                        'streetLines':[$('input[name="shipper_streetLines"]').val()],
                        'city':$('input[name="shipper_city"]').val(),
                        'stateOrProvinceCode':$('input[name="shipper_stateOrProvinceCode"]').val(),
                        'countryCode':$('select[name="shipper_countryCode"]').val(),
                    }
                },
                'recipients': [
                    {
                        'contact': {
                            'personName': $('input[name="recipient_personName"]').val(),
                            'phoneNumber': $('input[name="recipient_phoneNumber"]').val()
                        },
                        'address':{
                            'streetLines':[
                                $('input[name="recipient_streetLines"]').val()
                            ],
                            'city': $('input[name="recipient_city"]').val(),
                            'stateOrProvinceCode': $('input[name="recipient_stateOrProvinceCode"]').val(),
                            'postalCode': $('input[name="recipient_postalCode"]').val(),
                            'countryCode': $('input[name="recipient_countryCode"]').val()
                        }
                        
                    }
                ],
                'serviceType': $('select[name="serviceType"]').val(),
                'packagingType': $('select[name="packagingType"]').val(),
                'pickupType': $('select[name="pickupType"]').val(),
                'shippingChargesPayment': {
                    'paymentType': $('select[name="paymentType"]').val()
                },
                'requestedPackageLineItems':[
                    {
                        'weight':{
                            'units':'LB',
                            'value': $('select[name="weight_value"]').val() 
                        }
                    }
                ],
            },
            'accountNumber': {
                'value': $('input[name="accountNumber"]').val()
            }
            
        }
        
        );
        console.log($input);
        
 
        $.ajax({
            type:'POST',
            url:$url + '/openShip',
            data: {
                open_shipment: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
                        console.log("SMN " + data.statusCode);
                        console.log(JSON.stringify(data));
                        if (window.confirm(JSON.stringify(data))){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        console.log("NEL " + data.statusCode);
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        console.log("Def " + data.statusCode);
                        console.log(JSON.stringify(data));
                        window.confirm(data.validateAddressJson.errors[0].code + " " + JSON.stringify(data.cookie))
                }
            },
            error:function(data){
                alert(JSON.stringify(data));
            }
        });
    });
    $('#modify-open-ship').on('submit', function(event){
        $url = $(this).attr('data-action');
        const selector = document.querySelectorAll("#modify-open-ship");
        $input = JSON.stringify({
            'index': "Test1234",
            'requestedShipment': {
                'shipper':{
                    'contact': {
                        'personName': selector[0]["shipper_personName"].value,
                        'phoneNumber':selector[0]["shipper_phoneNumber"].value,
                    },
                    'address':{
                        'streetLines':[selector[0]["shipper_streetLines"].value],
                        'city':selector[0]["shipper_personName"].value,
                        'stateOrProvinceCode':selector[0]["shipper_stateOrProvinceCode"].value,
                        'countryCode':selector[0]["shipper_countryCode"].value,
                    }
                },
                'recipients': [
                    {
                        'contact': {
                            'personName': selector[0]["recipient_personName"].value,
                            'phoneNumber': selector[0]["recipient_phoneNumber"].value
                        },
                        'address':{
                            'streetLines':[
                                selector[0]["recipient_streetLines"].value
                            ],
                            'city': selector[0]["recipient_city"].value,
                            'stateOrProvinceCode': selector[0]["recipient_stateOrProvinceCode"].value,
                            'countryCode': selector[0]["recipient_countryCode"].value
                        }
    
                    }
                ],
                'serviceType': selector[0]["serviceType"].value,
                'packagingType': selector[0]["packagingType"].value,
                'pickupType':  selector[0]["pickupType"].value,
                'shippingChargesPayment': {
                    'paymentType': selector[0]["paymentType"].value
                },
                'requestedPackageLineItems':[
                    {
                        'weight':{
                            'units':'LB',
                            'value': selector[0]["weight_value"].value
                        }
                    }
                ],
            },
            'accountNumber': {
                'value': selector[0]["accountNumber"].value
            }
    
        }
    
        );
        console.log($input);
        $.ajax({
            type:'PUT',
            url:$url + '/modifyOpenShip',
            data: {
                open_shipment: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
                        console.log("SMN " + data.statusCode);
                        console.log(JSON.stringify(data));
                        if (window.confirm(JSON.stringify(data))){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        console.log("NEL " + data.statusCode);
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        console.log("Def " + data.statusCode);
                        console.log(JSON.stringify(data));
                        window.confirm(data.validateAddressJson.errors[0].code + " " + JSON.stringify(data.cookie))
                }
            },
            error:function(data){
                console.log("ERROR DE CONEXIÓN");
                alert(JSON.stringify(data));
            }
        });
    });
    $('#confirm-open-ship').on('submit', function(event){
        $url = $(this).attr('data-action');
        $input =JSON.stringify(
        {
            "accountNumber": {
              "value": "Your account number"
            },
            "index": "Test1234",
            "labelResponseOptions": "URL_ONLY",
            "labelSpecification": {
              "labelStockType": "PAPER_85X11_TOP_HALF_LABEL",
              "imageType": "PDF"
            }
          });

        
        $.ajax({
            type:'POST',
            url:$url + '/confirmOpenShip',
            data: {
                open_shipment: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
                        console.log("SMN " + data.statusCode);
                        console.log(JSON.stringify(data));
                        if (window.confirm(JSON.stringify(data))){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        console.log("NEL " + data.statusCode);
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        console.log("Def " + data.statusCode);
                        console.log(JSON.stringify(data));
                        window.confirm(data.validateAddressJson.errors[0].code + " " + JSON.stringify(data.cookie))
                }
            },
            error:function(data){
                console.log("ERROR DE CONEXIÓN");
                alert(JSON.stringify(data));
            }
        });
    });
    $('#modify-open-ship-packages').on('submit', function(event){
        $url = $(this).attr('data-action');
        $input =JSON.stringify(
            {
                "accountNumber": {
                  "value": "8014xxxxx"
                },
                "index": "Test1234",
                "trackingId": {
                  "trackingIdType": "FEDEX",
                  "formId": "0263",
                  "trackingNumber": "7950095xxxxx"
                },
                "requestedPackageLineItem": {
                  "weight": {
                    "units": "LB",
                    "value": "20"
                  },
                  "dimensions": {
                    "length": "12",
                    "height": "12",
                    "width": "16",
                    "units": "IN"
                  },
                  "declaredValue": {
                    "currency": "USD",
                    "amount": "100"
                  }
                }
              }
        );

        
        $.ajax({
            type:'PUT',
            url:$url + '/modifyOpenShipPackage',
            data: {
                modify_openShipment: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
                        console.log("SMN " + data.statusCode);
                        console.log(JSON.stringify(data));
                        if (window.confirm(JSON.stringify(data))){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        console.log("NEL " + data.statusCode);
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        console.log("Def " + data.statusCode);
                        console.log(JSON.stringify(data));
                        window.confirm(data.validateAddressJson.errors[0].code + " " + JSON.stringify(data.cookie))
                }
            },
            error:function(data){
                console.log("ERROR DE CONEXIÓN");
                alert(JSON.stringify(data));
            }
        });
    });
    $('#add-open-ship-packages').on('submit', function(event){
        $url = $(this).attr('data-action');
        $input =JSON.stringify(
            {
                "accountNumber": {
                  "value": "8014xxxxx"
                },
                "index": "Test1234",
                "requestedPackageLineItems": [
                  {
                    "weight": {
                      "units": "LB",
                      "value": "20"
                    },
                    "declaredValue": {
                      "currency": "USD",
                      "amount": "100"
                    }
                  }
                ]
              }
        );

        
        $.ajax({
            type:'POST',
            url:$url + '/addOpenShipmentPackages',
            data: {
                add_openShipmentPackages: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
                        console.log("SMN " + data.statusCode);
                        console.log(JSON.stringify(data));
                        if (window.confirm(JSON.stringify(data))){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        console.log("NEL " + data.statusCode);
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        console.log("Def " + data.statusCode);
                        console.log(JSON.stringify(data));
                        window.confirm(data.validateAddressJson.errors[0].code + " " + JSON.stringify(data.cookie))
                }
            },
            error:function(data){
                console.log("ERROR DE CONEXIÓN");
                alert(JSON.stringify(data));
            }
        });
    });
    $('#retrieve-open-ship-packages').on('submit', function(event){
        $url = $(this).attr('data-action');
        $input =JSON.stringify(
            {
                "accountNumber": {
                  "value": "801472842"
                },
                "index": "Test1234",
                "trackingId": {
                  "trackingIdType": "FEDEX",
                  "formId": "0263",
                  "trackingNumber": "795009503570"
                }
              }
        );

        
        $.ajax({
            type:'POST',
            url:$url + '/retrieveOpenShipmentPackage',
            data: {
                retrieve_openShipmentPackage: $input,
                _token: $('input[name="_token"]').val(), 
            },
            success:function(data) {
                //window.confirm(data.validateAddressJson.errors[0].code + " " +JSON.stringify(data.cookie))
                switch(data.statusCode){
                    case 200:
                        console.log("SMN " + data.statusCode);
                        console.log(JSON.stringify(data));
                        if (window.confirm(JSON.stringify(data))){
                            //window.location = $url;
                        }
                    break;
                    case 400:
                    case 401:
                    case 403:
                    case 404:
                    case 500:
                    case 503:
                        console.log("NEL " + data.statusCode);
                        window.confirm(data.statusCode + " " + JSON.stringify(data))
                        console.log(JSON.stringify(data));
                    break;
                    default:
                        console.log("Def " + data.statusCode);
                        console.log(JSON.stringify(data));
                        window.confirm(data.validateAddressJson.errors[0].code + " " + JSON.stringify(data.cookie))
                }
            },
            error:function(data){
                console.log("ERROR DE CONEXIÓN");
                alert(JSON.stringify(data));
            }
        });
    });

});