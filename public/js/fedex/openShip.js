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


    $('#modify-open-ship').on('submit', function(event){
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

        // $input = JSON.stringify(
        //     {
        //         "index": "Test1234",
        //         "requestedShipment": {
        //           "shipper": {
        //             "contact": {
        //               "personName": "SENDER NAME",
        //               "phoneNumber": "901xxx8595"
        //             },
        //             "address": {
        //               "streetLines": [
        //                 "SENDER ADDRESS 1"
        //               ],
        //               "city": "MEMPHIS",
        //               "stateOrProvinceCode": "TN",
        //               "postalCode": "38116",
        //               "countryCode": "US"
        //             }
        //           },
        //           "recipients": [
        //             {
        //               "contact": {
        //                 "personName": "RECIPIENT NAME",
        //                 "phoneNumber": "901xxx8595"
        //               },
        //               "address": {
        //                 "streetLines": [
        //                   "RECIPIENT ADDRESS 1"
        //                 ],
        //                 "city": "MEMPHIS",
        //                 "stateOrProvinceCode": "TN",
        //                 "postalCode": "38116",
        //                 "countryCode": "US"
        //               }
        //             }
        //           ],
        //           "serviceType": "STANDARD_OVERNIGHT",
        //           "packagingType": "YOUR_PACKAGING",
        //           "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
        //           "shippingChargesPayment": {
        //             "paymentType": "SENDER"
        //           },
        //           "requestedPackageLineItems": [
        //             {
        //               "weight": {
        //                 "units": "LB",
        //                 "value": "20"
        //               }
        //             }
        //           ]
        //         },
        //         "accountNumber": {
        //           "value": "Your account number"
        //         }
        //       }
        // );

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

        // $input = JSON.stringify(
        //     {
        //         "index": "Test1234",
        //         "requestedShipment": {
        //           "shipper": {
        //             "contact": {
        //               "personName": "SENDER NAME",
        //               "phoneNumber": "901xxx8595"
        //             },
        //             "address": {
        //               "streetLines": [
        //                 "SENDER ADDRESS 1"
        //               ],
        //               "city": "MEMPHIS",
        //               "stateOrProvinceCode": "TN",
        //               "postalCode": "38116",
        //               "countryCode": "US"
        //             }
        //           },
        //           "recipients": [
        //             {
        //               "contact": {
        //                 "personName": "RECIPIENT NAME",
        //                 "phoneNumber": "901xxx8595"
        //               },
        //               "address": {
        //                 "streetLines": [
        //                   "RECIPIENT ADDRESS 1"
        //                 ],
        //                 "city": "MEMPHIS",
        //                 "stateOrProvinceCode": "TN",
        //                 "postalCode": "38116",
        //                 "countryCode": "US"
        //               }
        //             }
        //           ],
        //           "serviceType": "STANDARD_OVERNIGHT",
        //           "packagingType": "YOUR_PACKAGING",
        //           "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
        //           "shippingChargesPayment": {
        //             "paymentType": "SENDER"
        //           },
        //           "requestedPackageLineItems": [
        //             {
        //               "weight": {
        //                 "units": "LB",
        //                 "value": "20"
        //               }
        //             }
        //           ]
        //         },
        //         "accountNumber": {
        //           "value": "Your account number"
        //         }
        //       }
        // );

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
});