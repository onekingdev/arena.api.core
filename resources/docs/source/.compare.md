---
title: API Reference

language_tabs:
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](arena.api/docs/collection.json)

<!-- END_INFO -->

#Accounting


<!-- START_91f0c3ccc2088099db6c850259363db9 -->
## office/invoice/user/invoices
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/user/invoices"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/invoice/user/invoices`


<!-- END_91f0c3ccc2088099db6c850259363db9 -->

<!-- START_5b26fb87169e16ca75085c39f45b2b27 -->
## office/invoice/{invoice}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/invoice/{invoice}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `InvoiceUUID` |  required  | Invoice UUID

<!-- END_5b26fb87169e16ca75085c39f45b2b27 -->

<!-- START_7a72cef046ca802a5d9a6b0861f978e7 -->
## office/invoice/{invoice}/type
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/1/type"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/invoice/{invoice}/type`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `InvoiceUUID` |  required  | Invoice UUID

<!-- END_7a72cef046ca802a5d9a6b0861f978e7 -->

<!-- START_aa2b7f931fdbfedcc0670668dc1eb7a0 -->
## account/soundblock/projects
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/projects"
);

let params = {
    "per_page": "6",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/projects`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `per_page` |  optional  | Items per page

<!-- END_aa2b7f931fdbfedcc0670668dc1eb7a0 -->

<!-- START_e8c56d1809c0e5a61816648be5688b54 -->
## account/soundblock/project/{project_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/project/officia"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/project/{project_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project_uuid` |  required  | Project UUID

<!-- END_e8c56d1809c0e5a61816648be5688b54 -->

<!-- START_da80ef6ee28e422e5317c6c4e788100f -->
## account/soundblock/project/{project_uuid}/deployments
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/project/voluptas/deployments"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/project/{project_uuid}/deployments`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project_uuid` |  required  | Project UUID

<!-- END_da80ef6ee28e422e5317c6c4e788100f -->

<!-- START_d3fb17ad115ca5908570cd8cab0195f6 -->
## account/soundblock/project/{project_uuid}/service
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/project/numquam/service"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/project/{project_uuid}/service`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project_uuid` |  required  | Project UUID

<!-- END_d3fb17ad115ca5908570cd8cab0195f6 -->

<!-- START_2f2746196eda5cd781a15f0ef9fb7e77 -->
## account/soundblock/project/{project_uuid}/members
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/project/voluptas/members"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/project/{project_uuid}/members`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project_uuid` |  required  | Project UUID

<!-- END_2f2746196eda5cd781a15f0ef9fb7e77 -->

<!-- START_627a1776301d9e600439fb503af8e0ed -->
## account/soundblock/services
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/services"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/services`


<!-- END_627a1776301d9e600439fb503af8e0ed -->

<!-- START_89a3780ececae34f448822230597038c -->
## account/soundblock/service/{service_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/service/provident"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/service/{service_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `service_uuid` |  required  | Service UUID

<!-- END_89a3780ececae34f448822230597038c -->

<!-- START_d282efb9d66a7699f51405a76d82dc7d -->
## account/soundblock/service/{service_uuid}/transaction
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/service/ut/transaction"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/service/{service_uuid}/transaction`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `service_uuid` |  required  | Service UUID

<!-- END_d282efb9d66a7699f51405a76d82dc7d -->

<!-- START_fffc52aebc5de2e4e129f1ed4b43a88a -->
## account/soundblock/service/{service_uuid}/plan
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/service/et/plan"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/service/{service_uuid}/plan`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `service_uuid` |  required  | Service UUID

<!-- END_fffc52aebc5de2e4e129f1ed4b43a88a -->

<!-- START_22af462c0a8fa59dd51b9dc31ddd57d1 -->
## account/soundblock/service/{service_uuid}/user
> Example request:

```javascript
const url = new URL(
    "arena.api/account/soundblock/service/omnis/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/soundblock/service/{service_uuid}/user`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `service_uuid` |  required  | Service UUID

<!-- END_22af462c0a8fa59dd51b9dc31ddd57d1 -->

<!-- START_b5bc99e4a4d5ca0743bc23b43fbdb818 -->
## account/invoices
> Example request:

```javascript
const url = new URL(
    "arena.api/account/invoices"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/invoices`


<!-- END_b5bc99e4a4d5ca0743bc23b43fbdb818 -->

<!-- START_6447f2bfa9996435a173c8c55e51fd6a -->
## account/invoice/{invoice_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/account/invoice/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/invoice/{invoice_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `InvoiceUUID` |  required  | Invoice UUID

<!-- END_6447f2bfa9996435a173c8c55e51fd6a -->

<!-- START_60b04e2a3e6441bdc2da73a45a768287 -->
## account/invoice/{invoice_uuid}/type
> Example request:

```javascript
const url = new URL(
    "arena.api/account/invoice/1/type"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET account/invoice/{invoice_uuid}/type`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `InvoiceUUID` |  required  | Invoice UUID

<!-- END_60b04e2a3e6441bdc2da73a45a768287 -->

#Apparel


<!-- START_b0167629de9911ba9d69a5ec09d7b95a -->
## apparel/file/{file}
> Example request:

```javascript
const url = new URL(
    "arena.api/apparel/file/eos"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET apparel/file/{file}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `file` |  required  | UUID of file

<!-- END_b0167629de9911ba9d69a5ec09d7b95a -->

<!-- START_1a6d6afde72484c315805e7087e6a98a -->
## apparel/products/{productUuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/apparel/products/ut"
);

let params = {
    "color": "reprehenderit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
    "product_name": "Mens Court Shorts - 5910",
    "product_description": "Regular Fit - Mid Weight",
    "stamp_created": 1584897458,
    "stamp_created_at": "2020-03-23 00:17:38",
    "stamp_created_by": 1,
    "stamp_updated": 1584906054,
    "stamp_updated_at": "2020-03-23 02:40:54",
    "stamp_updated_by": 1,
    "product_sizes": [
        {
            "row_uuid": "c68d5af2-740f-439c-97fb-1f38fec4a686",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "size_name": "S",
            "stamp_created": 1584897479,
            "stamp_created_at": "2020-03-23 00:17:59",
            "stamp_created_by": 1,
            "stamp_updated": 1584897479,
            "stamp_updated_at": "2020-03-23 00:17:59",
            "stamp_updated_by": 1
        },
        {
            "row_uuid": "ad6f7ed2-a757-4ef7-adc4-dd9c97730ab5",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "size_name": "M",
            "stamp_created": 1584897479,
            "stamp_created_at": "2020-03-23 00:17:59",
            "stamp_created_by": 1,
            "stamp_updated": 1584897479,
            "stamp_updated_at": "2020-03-23 00:17:59",
            "stamp_updated_by": 1
        },
        {
            "row_uuid": "0ae5f2e6-49cf-4875-8d48-c8379bfa0871",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "size_name": "L",
            "stamp_created": 1584897479,
            "stamp_created_at": "2020-03-23 00:17:59",
            "stamp_created_by": 1,
            "stamp_updated": 1584897479,
            "stamp_updated_at": "2020-03-23 00:17:59",
            "stamp_updated_by": 1
        },
        {
            "row_uuid": "71125779-54ee-4762-9933-fa0fb80a1f21",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "size_name": "XL",
            "stamp_created": 1584897479,
            "stamp_created_at": "2020-03-23 00:17:59",
            "stamp_created_by": 1,
            "stamp_updated": 1584897479,
            "stamp_updated_at": "2020-03-23 00:17:59",
            "stamp_updated_by": 1
        },
        {
            "row_uuid": "02440152-5e84-4d28-9875-dc078d061885",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "size_name": "2XL",
            "stamp_created": 1584897479,
            "stamp_created_at": "2020-03-23 00:17:59",
            "stamp_created_by": 1,
            "stamp_updated": 1584897479,
            "stamp_updated_at": "2020-03-23 00:17:59",
            "stamp_updated_by": 1
        }
    ],
    "product_style": [
        {
            "row_uuid": "6a35021d-9dc1-4dc6-a4de-742dab139a25",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "style_name": "navy",
            "stamp_created": 1584897458,
            "stamp_created_at": "2020-03-23 00:17:38",
            "stamp_created_by": 1,
            "stamp_updated": 1584897465,
            "stamp_updated_at": "2020-03-23 00:17:45",
            "stamp_updated_by": 1,
            "image_uuid": "b272a301-6a87-458e-86bc-ec844c223a49",
            "thumbnail_uuid": "9ff974e6-e116-4cfc-ba52-d5f36e956783",
            "image": {
                "file_uuid": "b272a301-6a87-458e-86bc-ec844c223a49",
                "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/small_image\/460x460\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_navy.jpg",
                "file_name": "d0bf97b74c44bd96da78efecf2220e2e.jpg",
                "file_type": "image",
                "stamp_created": 1584897465,
                "stamp_created_at": "2020-03-23 00:17:45",
                "stamp_created_by": 1,
                "stamp_updated": 1584897465,
                "stamp_updated_at": "2020-03-23 00:17:45",
                "stamp_updated_by": 1,
                "url": "http:\/\/test.arena.loc\/images\/products\/d0bf97b74c44bd96da78efecf2220e2e.jpg"
            },
            "thumbnail": {
                "file_uuid": "9ff974e6-e116-4cfc-ba52-d5f36e956783",
                "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/image\/60x60\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_navy.jpg",
                "file_name": "8abbd2c696ef792258041e39415ee2d3.jpg",
                "file_type": "image",
                "stamp_created": 1584897465,
                "stamp_created_at": "2020-03-23 00:17:45",
                "stamp_created_by": 1,
                "stamp_updated": 1584897465,
                "stamp_updated_at": "2020-03-23 00:17:45",
                "stamp_updated_by": 1,
                "url": "http:\/\/test.arena.loc\/images\/products\/8abbd2c696ef792258041e39415ee2d3.jpg"
            }
        },
        {
            "row_uuid": "99855073-eff1-44ff-903b-bd9d9a941a77",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "style_name": "white",
            "stamp_created": 1584897465,
            "stamp_created_at": "2020-03-23 00:17:45",
            "stamp_created_by": 1,
            "stamp_updated": 1584897472,
            "stamp_updated_at": "2020-03-23 00:17:52",
            "stamp_updated_by": 1,
            "image_uuid": "471a8ea4-8db9-44bb-8c02-c231134be09b",
            "thumbnail_uuid": "d7fc9408-7889-464c-ac5f-4747ba64f09e",
            "image": {
                "file_uuid": "471a8ea4-8db9-44bb-8c02-c231134be09b",
                "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/small_image\/460x460\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_white_front.jpg",
                "file_name": "6c9edcd147375c855da296b0ec29ae0d.jpg",
                "file_type": "image",
                "stamp_created": 1584897472,
                "stamp_created_at": "2020-03-23 00:17:52",
                "stamp_created_by": 1,
                "stamp_updated": 1584897472,
                "stamp_updated_at": "2020-03-23 00:17:52",
                "stamp_updated_by": 1,
                "url": "http:\/\/test.arena.loc\/images\/products\/6c9edcd147375c855da296b0ec29ae0d.jpg"
            },
            "thumbnail": {
                "file_uuid": "d7fc9408-7889-464c-ac5f-4747ba64f09e",
                "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/image\/60x60\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_white_front.jpg",
                "file_name": "49258825240f60516ccd64db0385b8c2.jpg",
                "file_type": "image",
                "stamp_created": 1584897472,
                "stamp_created_at": "2020-03-23 00:17:52",
                "stamp_created_by": 1,
                "stamp_updated": 1584897472,
                "stamp_updated_at": "2020-03-23 00:17:52",
                "stamp_updated_by": 1,
                "url": "http:\/\/test.arena.loc\/images\/products\/49258825240f60516ccd64db0385b8c2.jpg"
            }
        },
        {
            "row_uuid": "365cb700-2357-46bb-a4a0-d1ccccd85d39",
            "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
            "style_name": "black",
            "stamp_created": 1584897472,
            "stamp_created_at": "2020-03-23 00:17:52",
            "stamp_created_by": 1,
            "stamp_updated": 1584897479,
            "stamp_updated_at": "2020-03-23 00:17:59",
            "stamp_updated_by": 1,
            "image_uuid": "dac03898-04aa-4f31-8b49-f91f2ce5c229",
            "thumbnail_uuid": "65a2253c-55b0-4bf2-9f48-88071fc2c40f",
            "image": {
                "file_uuid": "dac03898-04aa-4f31-8b49-f91f2ce5c229",
                "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/small_image\/460x460\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_black_front.jpg",
                "file_name": "59f5e048a7cd3a4c54539dc4b0948dda.jpg",
                "file_type": "image",
                "stamp_created": 1584897479,
                "stamp_created_at": "2020-03-23 00:17:59",
                "stamp_created_by": 1,
                "stamp_updated": 1584897479,
                "stamp_updated_at": "2020-03-23 00:17:59",
                "stamp_updated_by": 1,
                "url": "http:\/\/test.arena.loc\/images\/products\/59f5e048a7cd3a4c54539dc4b0948dda.jpg"
            },
            "thumbnail": {
                "file_uuid": "65a2253c-55b0-4bf2-9f48-88071fc2c40f",
                "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/image\/60x60\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_black_front.jpg",
                "file_name": "1e1c07089190e9efca55e456e3120a34.jpg",
                "file_type": "image",
                "stamp_created": 1584897479,
                "stamp_created_at": "2020-03-23 00:17:59",
                "stamp_created_by": 1,
                "stamp_updated": 1584897479,
                "stamp_updated_at": "2020-03-23 00:17:59",
                "stamp_updated_by": 1,
                "url": "http:\/\/test.arena.loc\/images\/products\/1e1c07089190e9efca55e456e3120a34.jpg"
            }
        }
    ],
    "current_style": {
        "row_uuid": "6a35021d-9dc1-4dc6-a4de-742dab139a25",
        "product_uuid": "7f8ba4c7-9f15-471e-a939-d89c7d130e59",
        "style_name": "navy",
        "stamp_created": 1584897458,
        "stamp_created_at": "2020-03-23 00:17:38",
        "stamp_created_by": 1,
        "stamp_updated": 1584897465,
        "stamp_updated_at": "2020-03-23 00:17:45",
        "stamp_updated_by": 1,
        "image_uuid": "b272a301-6a87-458e-86bc-ec844c223a49",
        "thumbnail_uuid": "9ff974e6-e116-4cfc-ba52-d5f36e956783",
        "image": {
            "file_uuid": "b272a301-6a87-458e-86bc-ec844c223a49",
            "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/small_image\/460x460\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_navy.jpg",
            "file_name": "d0bf97b74c44bd96da78efecf2220e2e.jpg",
            "file_type": "image",
            "stamp_created": 1584897465,
            "stamp_created_at": "2020-03-23 00:17:45",
            "stamp_created_by": 1,
            "stamp_updated": 1584897465,
            "stamp_updated_at": "2020-03-23 00:17:45",
            "stamp_updated_by": 1,
            "url": "http:\/\/test.arena.loc\/images\/products\/d0bf97b74c44bd96da78efecf2220e2e.jpg"
        },
        "thumbnail": {
            "file_uuid": "9ff974e6-e116-4cfc-ba52-d5f36e956783",
            "file_url": "https:\/\/www.ascolour.com\/media\/catalog\/product\/cache\/3\/image\/60x60\/040ec09b1e35df139433887a97daa66f\/5\/9\/5910_court_short_navy.jpg",
            "file_name": "8abbd2c696ef792258041e39415ee2d3.jpg",
            "file_type": "image",
            "stamp_created": 1584897465,
            "stamp_created_at": "2020-03-23 00:17:45",
            "stamp_created_by": 1,
            "stamp_updated": 1584897465,
            "stamp_updated_at": "2020-03-23 00:17:45",
            "stamp_updated_by": 1,
            "url": "http:\/\/test.arena.loc\/images\/products\/8abbd2c696ef792258041e39415ee2d3.jpg"
        }
    }
}
```

### HTTP Request
`GET apparel/products/{productUuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `productUuid` |  required  | Product UUID
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `color` |  optional  | Colour UUID

<!-- END_1a6d6afde72484c315805e7087e6a98a -->

#Authentication


APIs for authentication
<!-- START_22ff5a096dd18b7efdb1eebebe8d9f94 -->
## core/auth/signin
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/signin"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "password": "veritatis",
    "user": "quod",
    "2fa_code": 20
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": {
        "auth": {
            "token_type": "Bearer",
            "expires_in": 86400,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNjUwNmVjNmY4MTZmZDI0NmIzYWJkYmRiMjUzNDExM2ZlYWIxZDkwMTc4YzI1ODg4OTkzNTY0NDhmZTlhM2MyMTZhNDBmNzMzOWVkZTAwM2UiLCJpYXQiOjE1ODMyNTI1MjgsIm5iZiI6MTU4MzI1MjUyOCwiZXhwIjoxNTgzMzM4OTI4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.zkg-_azoTnK0z9rs04KWbTpp0A4q3QjI91mgmTuwUVcw-PHc4hLxkJjZrcxN_xqJAD2DEmoMziAD6rjkyPCAGEFUHTuBbY29Ufopfok7X_03cL3PGDMHxeU0J_DAxabDCKFHgjCKMfZBzpcFnyRkKAm_0BmxtOEq9MUDKP-FdS3IEZGsJJcoUBhFpQCbSuADALZEngoGfCl8dFZPcWgy9y_xrV_kadX26s5BuIsgUmsMY4pKPYYwwWGgr1J71N6L5ouiTu-ohZhJXrsTRg-o5hqYBgxSHz__s1qmr93f7v531EkhAc6vBGLlrLocD2L1WnEuir0gDqK2VdO1_UfTB07gfQL5G-oAypiW8lRnBzWO-c5ivqyWaTjlcwgsbMTxMTwXEdSB58BcVQ4fvEyFPttm8NtHxSOjCSTCHfUDhyD0RoVI49WuNEPR1oZf70C4JklyUsvOdTraTs4ADzec9nGj5RXhoMO4RE3z8a1h184xfon6Wyu_kJEXrCTJDZu0SEYHeyVnUk_dM4QQkgilR2ykCQXDOxt1Wqg-mfPRdChD4N7RtSPj1gjQ5HJvdSefeO-mmSewqgKJ0FDqL90sZ2eoAG0MmhA6qYTV37x1LVnm615NsEUmdCd-p9q1CuXRU1HBtgsKbpUb6J4smeRdoW6t76sb7HOKYlISx7xQaCo",
            "refresh_token": "def50200c921033a8e2fee78d48d697eb26088a40cfe2bad9964053f2efa7840fb9af978e2e618c4f0bcf4048db0126f2b0af0b23f099a2f863930ddc48dccf34f41d69975aed4ed34dbba29b5bdf31136002c7333700131238f36746cb9dfcd079ecd2fa35946ac6c01405cb3e0f89649f770e654f6e4bcd2d4678c630c965caa1196ffe400e20f0267d7ecb051ccda2a497df7b7dd24f81548752ca0f85d7165d9c99822767e69e6c35e2beabce829aaf23eff585d46635b472dba707dd6d08157c4369b09d61576602befe8eae08902d74f48e730532a37242e553f3bde1bfaf1d692f51bb4d0a20a2f99da39c22e2bdce077a169a5466c03f725a0678f0be1cb1133dec0d93e29714097aafbadf1236b7b8613684a2d778faeca296000bbabe19b3ca50d7ac1519799465089e19b17427e79d196670f7a92b57c2ae772197dbc96f935f594a45d5f641c8a69b2f525b3e78ff4e987d72e1a05aa41ea4a7971"
        },
        "user": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
    },
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```
> Example response (417):

```json
{
    "response": {
        "message": "The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.",
        "code": 10,
        "status_code": 500
    },
    "status": {
        "app": "Arena.API",
        "code": 417,
        "message": ""
    }
}
```
> Example response (449):

```json
{
    "data": null,
    "status": {
        "app": "Arena.API",
        "code": 449,
        "message": "2FA Code Required."
    }
}
```

### HTTP Request
`POST core/auth/signin`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `password` | string |  required  | The password of user
        `user` | string |  required  | The email or name of user
        `2fa_code` | integer |  optional  | optional 2FA Code
    
<!-- END_22ff5a096dd18b7efdb1eebebe8d9f94 -->

<!-- START_92c2cab15590c58075028b3055884e15 -->
## core/auth/signup
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/signup"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name_first": "ullam",
    "email": "molestiae",
    "user_password": "exercitationem",
    "user_password_confirmation": "voluptates"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": {
        "auth": {
            "token_type": "Bearer",
            "expires_in": 86400,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNjUwNmVjNmY4MTZmZDI0NmIzYWJkYmRiMjUzNDExM2ZlYWIxZDkwMTc4YzI1ODg4OTkzNTY0NDhmZTlhM2MyMTZhNDBmNzMzOWVkZTAwM2UiLCJpYXQiOjE1ODMyNTI1MjgsIm5iZiI6MTU4MzI1MjUyOCwiZXhwIjoxNTgzMzM4OTI4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.zkg-_azoTnK0z9rs04KWbTpp0A4q3QjI91mgmTuwUVcw-PHc4hLxkJjZrcxN_xqJAD2DEmoMziAD6rjkyPCAGEFUHTuBbY29Ufopfok7X_03cL3PGDMHxeU0J_DAxabDCKFHgjCKMfZBzpcFnyRkKAm_0BmxtOEq9MUDKP-FdS3IEZGsJJcoUBhFpQCbSuADALZEngoGfCl8dFZPcWgy9y_xrV_kadX26s5BuIsgUmsMY4pKPYYwwWGgr1J71N6L5ouiTu-ohZhJXrsTRg-o5hqYBgxSHz__s1qmr93f7v531EkhAc6vBGLlrLocD2L1WnEuir0gDqK2VdO1_UfTB07gfQL5G-oAypiW8lRnBzWO-c5ivqyWaTjlcwgsbMTxMTwXEdSB58BcVQ4fvEyFPttm8NtHxSOjCSTCHfUDhyD0RoVI49WuNEPR1oZf70C4JklyUsvOdTraTs4ADzec9nGj5RXhoMO4RE3z8a1h184xfon6Wyu_kJEXrCTJDZu0SEYHeyVnUk_dM4QQkgilR2ykCQXDOxt1Wqg-mfPRdChD4N7RtSPj1gjQ5HJvdSefeO-mmSewqgKJ0FDqL90sZ2eoAG0MmhA6qYTV37x1LVnm615NsEUmdCd-p9q1CuXRU1HBtgsKbpUb6J4smeRdoW6t76sb7HOKYlISx7xQaCo",
            "refresh_token": "def50200c921033a8e2fee78d48d697eb26088a40cfe2bad9964053f2efa7840fb9af978e2e618c4f0bcf4048db0126f2b0af0b23f099a2f863930ddc48dccf34f41d69975aed4ed34dbba29b5bdf31136002c7333700131238f36746cb9dfcd079ecd2fa35946ac6c01405cb3e0f89649f770e654f6e4bcd2d4678c630c965caa1196ffe400e20f0267d7ecb051ccda2a497df7b7dd24f81548752ca0f85d7165d9c99822767e69e6c35e2beabce829aaf23eff585d46635b472dba707dd6d08157c4369b09d61576602befe8eae08902d74f48e730532a37242e553f3bde1bfaf1d692f51bb4d0a20a2f99da39c22e2bdce077a169a5466c03f725a0678f0be1cb1133dec0d93e29714097aafbadf1236b7b8613684a2d778faeca296000bbabe19b3ca50d7ac1519799465089e19b17427e79d196670f7a92b57c2ae772197dbc96f935f594a45d5f641c8a69b2f525b3e78ff4e987d72e1a05aa41ea4a7971"
        },
        "user": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
    },
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`POST core/auth/signup`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name_first` | string |  required  | User First Name
        `email` | string |  required  | User Email
        `user_password` | string |  required  | User Password
        `user_password_confirmation` | string |  required  | User Password Confirmation
    
<!-- END_92c2cab15590c58075028b3055884e15 -->

<!-- START_fb9024a16ecc9788fbe872e2efa78c2a -->
## core/auth/refresh
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/refresh"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH core/auth/refresh`


<!-- END_fb9024a16ecc9788fbe872e2efa78c2a -->

<!-- START_2092a9b59a6ea0b3b5c1e49f6746b6b6 -->
## core/auth/forgot-password
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/forgot-password"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "Email": "eos",
    "Alias": "reprehenderit",
    "Phone": "magnam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/auth/forgot-password`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `Email` | email |  optional  | optional User Email
        `Alias` | string |  optional  | optional User Alias
        `Phone` | string |  optional  | optional User Contact Phone
    
<!-- END_2092a9b59a6ea0b3b5c1e49f6746b6b6 -->

<!-- START_995b38b66b0d5d4b3235ea0a2572e232 -->
## core/auth/password-reset/{resetToken}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/password-reset/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH core/auth/password-reset/{resetToken}`


<!-- END_995b38b66b0d5d4b3235ea0a2572e232 -->

<!-- START_54f83ba0d07ba37cc7cb7ed47e1b4557 -->
## core/auth/signout
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/signout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE core/auth/signout`


<!-- END_54f83ba0d07ba37cc7cb7ed47e1b4557 -->

<!-- START_800e1f5996aae2260da598c3f3d57978 -->
## core/auth/password
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/password"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/auth/password`


<!-- END_800e1f5996aae2260da598c3f3d57978 -->

<!-- START_044acb6e64675854de2340d8344b3839 -->
## core/auth/password
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/password"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH core/auth/password`


<!-- END_044acb6e64675854de2340d8344b3839 -->

<!-- START_3b040c7424b1e9a47c48c64baae7ef57 -->
## core/auth/index
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/index"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/auth/index`


<!-- END_3b040c7424b1e9a47c48c64baae7ef57 -->

<!-- START_fe187542939033fc5ea215563f29e0e7 -->
## Get 2FA Secrets

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/2fa/secret"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "secret": "GZMFQWCYLBMFQWCYCILSLIA2RMOIQO7Z",
        "qrCode": "data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADIEAQAAABXwbpWAAAABGdBTUEAALGPC\/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0T\/\/xSrMc0AACbvSURBVHja7Z15eFXF+cc\/IWy5YRMSdqFCWQSRVSugWEEUl4LVsNYAGpaggFVAAVksYBEjVQMioWqjUFzA9udW3MAKAtYiENYCorIpGjYFAmTh\/v64N7lz9nPuOffmJs73ec6Tc+7MvPO+M2dy5p2Z933j\/H6\/HwkJCV1UkE0gISEHiISEHCASEnKASEjIASIhIQeIhIQcIBIScoBISMgBIiEhB4iEhIQcIBIScoBISMgBIiEhB4iEhBwgEhKxh4puCfzrf7CrWnSZrtwPxn8Zvfq21YQPdyp\/6zkROr1mr3xhHDxzyDxP3Lcw4drQ8\/zPwP8rZZ4JtSHOF7jP7gTH3lamj\/k9JP5Xn\/7mQbDmKWdytyyCvk0D9\/nPQuZdFv9tz8BDrY3TMztD\/lvRfVfanIFbW7sg4HeJjEN+P0T36rjQH1WsOqbl4e3e9sufHWAtU9IUZZmkKdo8ha1D6anbtem5DYx5eLu383aesyZU\/nR96\/xN0szboePC6L8rGYfc9b2cYklISB1EQqKUdJBYwKv9rfMMjgeCOsOqM3DqHnd1nqmprLfFy9AlqB+cPw3\/vNelHC206W9cARTnmalN\/6i7kK5GTZdtey2w0nlfDF4hB4gGOwd7S6\/tqyaJR2CIjY5L2QCVgvf\/VxeWnHPHk7rOrKugy8PBwdMKhnyvTE\/dDpP\/bCLjXBhi0o4jZ8EQcdCstObJKbJ9cFU\/gaeeyvRRCfDAHSYyvKiVYfARoFGMvCux9AVps9wbOudTy8\/n2rBNFgA6HdumKzAu+PBVdHn8Id6hDL7w6msWD1WXesP7riFSB5GQKF86yNFtsCvDWZla6dCpu7d8rFsELIqsrGuKv3a9gGUm6TGMEh6H6MtQgrOwJl14vssivw1sXg+nFjv84k2C+leW4QGyKwN6OWy4SZOgk93MjWDtc+ZZ\/jQAeiWb5xFpfD0JhucZpwP0uF\/5PPoRc\/pL24GbmcRT\/aBQ4OGvPQI0zXh0ih73K1\/yOWugx+7Qc2Lv0H3BNuf9aoXXqkOGQ5qrgfpLy\/AAiQauu88iwzFrGi3HQb2i0ABRo1I8XDM6cP\/lyOjL2FW1k\/\/XHdo8l8+BpO\/Co793dphtW84hdRAJifL+Bckp8EBXOg9HCyJfjyO50gEHdR45AEeE\/G0mQKVM\/bxnFsF+8Us4GZjhQOYucoCUDRyBDo2ts61MN0773wDoUNliipMOpNtna3oatK8Uek5RKZ\/d9sFD843TwZonUaacAm3+\/ROgmUHZHfHQVZU\/2wfVhgo89YRpJvX3yoUx081lkAOkjKDvUKjUVT\/t8U8iU+ddzwf+5g00T2dBePRvOQG+14MDZIS3PBvtgxjK4Cuf743UQSQk5BcEvh9jkvh06fB0sEP06jpbAMevEn4YY8FTOyBHDpCyP0AaQaZFR77VEJqa7YP01P6kpjm+vXkd6vy\/EjYlK\/8GMh9V0WsBTaPYTGtug74ij+lanoe3Vw6KOWugRh1jmr4WwMngQx5kbtPvHzlAShnjLHZS3zrmnObNb0HLoAL6\/nHr\/FXeh1EPCz8ICmvFh0JHqgCKLofxMdBuLRpBn+AAMNoHMW3bk876QeogEhJyihV7OKGzVl+7UmzxVPE5qPFHb+s4vwzOFzhvm3DlqNQbqv\/bmHbcILjkTTlAHKFWeuBslRO0ul77+TbEEaijsw\/iTwjMiwF+eyl0EubWP13j3h5kkmr+3vBvoftjDSFZxx7kleLP9iXa8lZY74MNKiOqOhb7JM3nA\/Pt0fe10PI0rb1yH2RUAmQF7ws2Qp1uyvxN0uCAizZtdb3zdql1uowPkE7dHRw8NJjbusU01WAY7QHN6ybC7z4UfnCwEha3AZ50WF\/3CNuDNB6k5OmHeMggukg7ScxB6iASEqXxBYklS8ALM8D\/TWTrsCOvmCduN1TZZF6+6tLotpNTGeyk25Ehlq1GIzJAvLYLdovbxsNq1T5If9U8a0VW+PS\/ngjNl5nTV9uDdNsH64sfFkCCjh2E\/2qU68M4k8GJjHtnQysLGZZkwRIhT69cqD1NST9BLcMTmO6FJCwjpvGL2UlX46W3oFpQkX78E3cDRA+tC2HWC4H7vIEQCece2SdDZ7Fm6JzFeqIaNAt6U3znJuc8tB8Ij94QuD\/TQL\/8G8X7PT6IK4fvidRBJCTkFyQ8XBwQvHk+wvSN0tcB64IPf7agUSO8OjyT4XYi85ks6wOkcj\/ouDC6TNfJFx6qGdSfHbqtkaST5yZBhq3a9FZjxcm79zJsaAFWJ8rjVyh5UPOYOFb5rE5vbpEe\/zNQJ3wZVidby6Dut2i\/K5X7AW4cnfslNMj2WTtFFp1X75+gTZ+e5sx5tZ3LifPqrHna9E0jjGXeM8u982q9y3+4bL8LUgeRkIi4DnLEY64aeUC\/URRkOFIGe\/xIKdcp9osf+M5h3ztNL+0B8tRhmHSpt0xNyoEng0enz6eGt1YunsWywuOfwDSVTYhvkHmZvq8BjW0yU8WaXt5rzuSLu1+H5ibzMl1eAF4wTtfQ6yHcVw1PhjhVGxX1hwpvBO4HjNEurx\/PDx00XbBNa4ezNT9k679ukdY\/2fIUbx1my1UsA2xpE7IHUePLkc6cevhegbNmGRZAnMMB8vKn8LLHMi96G4YZMFrtGwsZ5D6IhMQvD3KASEiUtSnW65nwujB\/d4tbR8JOv\/K3nYVQLdte+Q+AUSO8k6\/oNmjWwHm5Zt0BgY\/dHcF3f9l64S6roZQh5uF6objI7\/cnhK7lKdq18LXPhdK35jtfS+8\/WlmHrUtAr1wtzdP1xSib5uUNg3gG81rtg6hR2NogiKdQv14QT\/V1doBF35i0z8bFWnrZPpfvgkWf2AnieTw\/RC4zR5u+VUhf+5w2fXlKrO2DVAiuFuVZrBpZpVshz+HlBL4wy7uVyUxGr+nlRYC+0z6SOoiEhNRBFFh0Dv4hrv89jyZ+3p8GYCsEgRFOzIEbhfI1kuAfFjpH\/lxzmndsd8fTs8vh2eLyk9HYfm94QsnzFavhmYGR68gnH4APp5vnmb8Q2j9mnL70ACw1aZPOHWHeodJ9YSf8JDwMAFQ62IvPw4uCDHcmwn0JpThA8o7DatVG4c7B0CJo6LNukTZ4zcr0gK9cCHg8bGphqK82duq4UNswivr9cFBVJn9D6H5sL1iS7E7u1cnO0htuD93H74b8jaoCtZWP3w0Dfmdeh+hr+MxZa54KR7iTqXmCuzb7Ihv8GyxkquSMx9V3h2KY7FsAbVXpfQ5hf0M3mqtYJZ23yLpzo4XSqDNcXiq1KofTlf9GuC0XeE\/btQ4ysTESElIHMcJTh8uGoGN7xQ4vFz+CMf2s82V9D9QMzr07wJm9MdzAb8FoGzHPF2cEzpHpYWEl2O7Q4d\/rbwauiMHtOnHGIe1a9M7BofSLPQJ7DuJVuDKUfqC9tvykHG0ZxbXXnKcmadbr7SK9OWu06XtmGde\/aYQ1\/elpyjJnz5jvg+jaUmSGynTbZ50\/t4F5u\/lFe5BayjQjexAxT95M8z0QOzIV9TcmMSnHuvzW\/BA\/RvsgIs8XnnH3fkd8Jz3uU6gWRrlq30f+n15JHZ845GFk7MgQdp0nVf0yO3ZksC3josjzLPdBJCSivYr1z5HwT7thzZ5GNz5HpMKihYMtc+Ff1wg\/DMHUrsIrPH6F8HWzYXOT9Xfjr6ElrjXgwYReYhz88bfOqpk7xoTHOjE4QtzqID8n+\/1HK4QuvbNYVldmjpKGF\/bbIj2rs1hGOojZWSz1lTVPWeepaubtJuYNV2ax\/PQ0b9rNydUr11wm9WXnLJb6OtBeSaPonlB9BbW1deTd6O1ZLNdfkOo\/QnXxh\/7h0alXFPh7ogCo7H7g16tC6PzPsej8symWwXHeBYQVUad6SshxXCyckLWU\/zlv6VY8DvUiLJPUQSQkIqmDrF0H3\/Rxz8jLieW3kYuWwjJVjPVK22FIs7Ivm1W\/DTvrjv4n+wChjpsfgvoGK265jeBfp5S\/XfY+9LiuFAfIF5fBJIujzGufg3rBOH\/nJmsD3lsFyOw\/GuYI3ipazfC2k+\/dAP1nKX9rdjB03\/1d2DPLnEbtx4GH9dMuvAvDVW3U7WJA1wdgHOxRdWz3c3Bsrn0Z0t+Eu2fZz3+iLnRNN88zZw30\/8w4vVUyrLaoZ9gRHHkaEdv5g37BwKICts6A+gZlc6+H4SrH6RmXKX1PxMQqlh6KHSDkFLgrHwlXmg0eBTMDv+rDVHqWHqZ70z4lmOqsfEOHwWc+zwqTryAKNgIzvO+LpMkhryYfbCv9L6TUQSQkYuEL4hYloZifx5av3PcPASbhmz\/bYZ7e\/d3AlwPg8CWww00ItEXAGyYyAXGPws2LvWuv3d3gwDsmGVKAdAftDtRoC92OOuy3qubtrJmy\/ywHiAaZOXDVRuP0runO43fckuQufc+s0LRqx1fW+a2Quh3uWy\/I1AJuEacWUyBXeH5nJtDUnKYv1zht3R0w2iHP2T5o9ReBR9UG7qgEKI7bWakrbLQY0L3+rW03szL\/6Oq+ncvtF+Qag8iasRyeK1wZiy63kbcK3kQbDZPHH+LD77MS\/Fv709WrQ54VNQNkW+z1mdRBJCRi4Qvy5cgw06uWTsOcPijw9ETptFHnvxrn3fkwnFetXHVsBRUmesTDveieNzPrx7iN0GmHOf0tNTE+DT3OGa8\/NYWvhDgvRGAvLc7v9\/vdENg8CI6cCD2fqQlDVnrLZP\/RkPq1cXrfj9zX8Xbv0P2J9dp9CzHdDg\/T0+AqYS+l2gW44dPQFKvi\/6x58mcavzRDdwQCg4rIbQBJQW\/pS56E0Y+4k8EpmqTBAWFQJQ527pTbrF8Aur0AdZoE9Swd59VqZBxyZ\/Xq+gvS6TXoJDy\/2p+I4HcfGiQcwZVRvjg3Lj7zo7c7nHyX8Zz764nARw54LiU0bGr8Vdo7W1+G0kb7H6HJVqmDSEiUTx0kdy2cfjvyjH49sfQbqzR5+PZluCi4DmK4Ns\/PQ+DnYh7rmtO70BWOdBd+qBmbbVR4ownNZmVggLzcDCapnKZlzVM+q+fC6nQ11PlXZEU3gGrrUZClOnvSNd07+vHXQtY95jKr8YfusEEcFPOV7Xh4LzSfb5+HLcO1Mln126gE6PyYeb81x5jm4kTYMtb+u3ChDzS3OKdn9S79+keXU\/BIO21Yfbc2fWW6Mb3j+dE3\/Ck2PjKCHYMpJ86rNcgMz2mD6LzajsGUGMTTynm1nhHXqATnThvEIJ56BlPn7jZpFhtOHFbfLYN4SkiUXR3ECMcaBm+s\/FF9DMeGxkZjlPAMJIE2wKRHtAHiZkIdi53oY3OB4iPva7Xpeesgr5jurQ75mOmNHCWoBZyTA0SrJ10SWPMX0fZF4WGZNr2esFF0cCI0VblpmZQDVTPt8zD7Re1vYp0bnrD2O1v\/IiDwsWcWtAzeJzfVyqCuU53eWli4yBsIySoZu\/WC9RZyKcq0UNbx7R8hWdwHsWgDCAbxLEa6Nr2RsMlX1QfTB2plXlLKg0DNc52\/AUsjWKHXczbDADoGMHIcZxuHDea+CeYBdKwu0WmDGnqO47LmGec\/O0Cbv9s+ax1EfRW2DhVJ3W6df\/+EUP63e2vTVx2z38yn64en23mtg4gBdKIBqYNISERyilUYB\/kRsPLLM4mlEbcCEi5alP8dUEzjOfc8+NoB08Ln2QtcuFKQabr7dowGz1a4mK9q59fdyySi8htQ0V+KA+SZQzBJ5dQsdbvy2XcNcJ9++Up9IHWZ8reMdpBhUmfHhbC5ZOKsre\/TZyBRnJPrHK9Wl1Gfa1LbvW\/sCddgvgdgpnOr66sxE\/h78CEFUm9Qpq9arrVJT3xDKZOaphrN25mnO7W9sGqzJmlw\/R9VhQR79Kt\/hCsEGucXQqLKzuf4spDJrR46OHQJlXEIXO1dRnofxCns7IN0XOiN82ozx3Hqa+Nicx3E6krd7qwd3AbxzJrn\/V6RuA+Sv0Gb3iTNmYz9RzsP4un0yjgkdRAJidjVQcKB2qIuvgqw1QWNihC\/PYp8X+t9G2jwe+d04nfH1stV1A4oVPX1bgcyvf4LHCA5BdBBZQuRmRMye6gwBLrtM6exoYWScd8gEP2TNT8Kjfdpyxih6rXaOtX5FeeWbNhyqOmJOoctexAbPrESVbpVbsOQPUjl\/tDtTmd9o5ZZLUO1FGf0alyhtQcpGhAyua3ZQltHHVHHaG\/vXTDjueoTwMIypINszdd3Xm0XRf215X2DzMtYOa9WI9vnfu5rdhbLbgAdp1dug\/D70SiAjhHs6CC+Qe4D6Bxob5zfKICO3AeRkCjzUyyjiKPpDvO7rQ9gcCm17oIY7\/0FMVDvuHI+QOK+Dfh0EtF2LvCqQYHx2vzj24fl\/b8Eea9BnJnts1PiKyBJ5ZPWiZ9cCJxbmm2Srm4DT7DJftbPs6DreHOe4sx8LtfW5q+cY11v\/AoUxj3nvoCqwbNUcVfotMspE2JjIEkdRNbrdo3GWSwzexC9s1jRuMx0EC\/sQawuxVmsUoCVPYgX0NNBnJzFigVIHURCwgRygEhIRFIHmf8ZPPEv4YcWZa8R\/vwePK0yzljfF1peEyUGnofkQ86LHTgPvqAv3ZkTYFEVZfp\/ukGz2wP372yCe\/\/hHcsFe6Dhy8rfauXAvvfCp\/nIRXjJ4kDo6u1w5TtlaID4f2WtwK59Dq4rsr9yMSkHnvzUwUKBjhLuTwCCBv03DjY3mPL7dGRIwPx0ogWmp8EsM4cDXwG\/Dt4XOl8EAEA4Re3\/CY6pjaYmAMEBwlQ4pvJ7teoY9Fke5orSCS3PPpUx09nuhLxdG0Go07\/Duh38+WXsC2Ib4yKU\/4jJKlUxjWOUDmJ8CTPiPI6VOoiEhNRBoo31Puj+Vdlu2NWTYbWJDHUvg3\/Gu6uj9+PBqRrAZDR26anpQvoirX44+2TgsotrUmD+VvM86n5b3wBDp9Ij58OufuIczZn8G9vCxLeUvz24C1L6etiRbteJL54NnC0yu6wg5g3HL5ZvkHmdVmexLr5vXt7OPkjWvFDZ3AbO90Gs2lDPL1a0Lyt7ECubdDv2IHpnsYz6JRpnsdzvpPvcH7NWlC\/wgIZTGW725qh4CY2GEeC\/jH9RPXs\/pA4iIfEL1kH23A+Pj4lsHfdOgcI\/CD\/UN8+\/5AP4TBXLe1Y+\/KqT\/To\/uzUYGBTgQ6CddZmhOxwIVbX0X5ZzXwg8V3dePn0m5DkMjzFtGWDUTj3K4QA5\/wwsdWh43380ZJspkyoj\/9W5cLCdffq5lbUOCKbNoiTwyc1ZcNbEc8vRS60dJKRuh8XC6cXEFrDBYduJPKRP1w+g47sucL+ss9b59KYRcLlBFNnDV2gdVcxZAw8Gg25eXAvVVfX1yoW3hQA2iW+Y8\/9FXdjSzpnMS9uV7j+FMhMG2leK5pdxUy0WWCY6k8FOEE89VNkmzMd3WLTTkw7bcbZ5\/jMNLOj5KJeQOoiERGl+QXLi4c173NOZMSK6DbPsACDUOaQjtA5OJ75qC690LXud\/ZYf3hpRvl\/o3TWV70qHZ+FON8E9I32eXi8+iNU1KSewl1B8Rdoe5HQfZX16NulWfrGy5ilpqK+TtZXtok43sjEXLxEna5une+EXS7RJ1\/PN2yvXXCY1T8damLeRkU26UX69fRCv\/WLFrA5S7J3jfCqwLLJ1VVsF1cQfEt3x7DjvAnTPkyVNwfCsVK3jsdtnRqiz14LANod0F0kdREJCrmKVBpY\/qFzp+cMySNzmjuYSgd6lt8EtbQ0yjoQlNuxmlpwzXo0CSHsG4oP\/XVfthEPvxVYbL\/kAUNmpj7oW6yPwAt4fomyD25tDw7uiJ0Oc3+\/3R7KCNanQSzVFWpkOHYVpjDr45KQcePLK0LNV5FS94JX7JwidMtk6gM7RCqE46SfPwUmV9\/RG66HKxsB9fiocrmfOw\/Q0mPWCfl16juOSpsB\/BFuH31S2to04OyC0zDpjhDaoj9gGO7dBX4s46Nk+uE7YxK12Cuq+YNwP8Seh6YvG9BIH6ziO6x9yHKfG95\/Buf8LPb83NODQQ8TWfGgf3Pc6Xxm+E6am57+DtipnIRmHYKKLIJ6l9gVp9lTg78EO9vPq4gigM0CaLQKKvXI4tAe5JAEuMamz8lJlBGKvQh8r5JzqLc2dN4XBg5N+8AANrkXp1tXii141X9kPu4ZIHURComzpIJsHwZETyt+u+9J6leWd4v9oFgHv\/Zvh3cmqT3snuPWJyDXKrr\/DfpW99dXHod6XgfvcRfD5\/1nTecfov\/al6Pr3VeTv4l6OndvsfznUuHAbfKg6WV2jO1w\/04G8dbzvm4O3wcGyNEDWPKUNoLNzcCDoKUDHvMAZIBFdFjvoqKe1c+eO\/WwHdTWEmqekPqH7\/46C4SqnaRsXQ7HacXCLlqesedBZcJzc5QXz+rvtg8x5Qv65oLDz+ch95\/Z1QePU+9BXFcVr1GcmA8QHfc9Zt3OFvzrgvzJ0E8p\/WxH6Wrw7y1OgZa3Qc+3KpTxALOfzb0Jn4TmnAHih9D+drd6Fat97S7NzsPOPNXSWP+ZdlLppk8dQRJlygqatoakwoL4d47BdpQ4iIRHjUywrHO8O+4aWj8b6PEvQD14wSZ+JsZNuvfxhTgO29QSyIiTjIn0ZPjeq72l7MovYshEuWKxUdToPlR8owwPkprZwhWoZtZHg0yqnGfSyaLjMHGghfIZr\/wsI7oNU\/Szgv0mhpP\/sjMepr8NEFQ3fLuP81\/wHVqmOd3e1CHiptr1QI3U7DBFo3pIEVucdV5ksTy\/\/Hrq2M85\/8EUtT6sslrtvSVK+5HPWQOcrlelL0r17+ea+DCssBviB9tAkOEA6ZWllcBqINOoD5MqfSt7lEO50TqePuOKRKtx\/A31wtzrS836dH68z0U+ugFbC8\/senXsqltGuPUif5RiexVquoz91aRc6t7REp0zyZOP5+d7Z5jwb2YNEE5ddhMuE53XyLJaERDnXQbyA+r9bhdfg1zu9o\/\/943D6okmG+0pJ7lMoLP1aTjfPf2IMnCjOX8XZlyJiMrykfLaSQY3zdyl5\/tWHUHldOR8g2SrzzBY3AUcNGigVWqnOcnVcCJs95OelbjCtp0mGGVqe1fskWfOgyp+MSdQcBgQ3GuPvh2wLnWXiA1ob8cLlIZPbO4dBL4Gn\/YO1+dU8d3GxvF71Hsh+1jzPcJ2AO2qeiraHzmINbAG3mZjq\/rwRWumdxQreNx4B2ZOU6Zdv9PhlLQ2DKTGAjhXO6ZTvuFDIcNjAYVmC\/TrmrLE2vLFjMOUlkqZo6zBzwjc9TZt\/\/4RQ+tu93RlMWSLBHk2zIJ5qZOoYUG3NlwF0JCTKjw5yui7kma3yGJyw\/MHEL22VWtZnuX6w8Gv7wwVAyFOvyH1jldR5r4e0jGAxBTs+EgrF+f090X95foj3lt6pOnDhlPDDFvP8hXXg+CnlbzV6QsJHMTRAsjZrz2IpsCywni4ipac5zUmfhGxkKj4Ac1Qv5LSeSl9wvkEwdVToecnfob7KTiF\/I1Qy2Hi4\/ISWRzW6ijy7PCpTdDnUv2iRycIW5MEHYKnIx4vm+evfDXOmaNtRhLoNLj9hTK9gow0ZdGhWeM44758\/gQxR52hvTnvjbOihWsJfXsvboMZRUdJ77IbrgitBOQUwzQmDXeBR4fniAP3yj96gHCBOcKeFhdr7MWj\/7RRXDYWrhOfPs7Tt2Ph2GHbW23ofbYnyLNYNZavdpA4iIVHaXxC3sLOLq8hzmzb9wp1wwUGd1b4mEIYtTD4rdYIqHtuInzsFFNfxkXOeqt0O\/NXbdneDvIfgomgi+8EvZICMUr1Yib3Dp3U+FaoftWjo11S+lF9U8rD\/IFRPdlbvnqecbWqNfgRGC8\/TG8Asg7xxmTCqnzN+dmyD6qKjh3badlZDbSe\/CaXpgZUCbqVj9MqF5k2Eqe05ZzINz4MVR5U6h5VMCV9Tcg4osbc2f62\/lYEB8sAd0GZ56Y78LCixSb\/xWGz9V6rQG7LynJXRi7j19O+Mfe0ueRLLlTBP2rlYDp\/++S+nmPsT1K5kL2+nFs7bUeogEhJlSgc5CwXimX+bttYFLo8MFKwGimmEGbu9hIeW7pvBUp7aUKmVO7qVukaBT6P8q9H1d1VwEMdG5IYy\/QUKHMpYcTLEfRrDA2RNutYvlt5cVkRGMmSYpFth32So3M28DrWfLHV6q2Rghn0ezPxu5Q20jp2RNAVy\/2ycful9Wh4SkwGBbm6D0HH3hJna\/BUXWusEw7vZ76fVyUpbryZp0EJwprFxnLYfrGjWURmPHWgPTbYG7t\/cBykTnL0LGYdsR6copS+IDfT7DsYFjUpOFGjNPWpPgzccOHpoqvPbqn2h\/0ajfYF\/eCL+Xi+02\/5yojZ9zptwzWj9+r6eCM0j3Eavfah8topOlXpOaVYDwGPueGjeJDTnL9iobwj5sWDAZMfF8bsPQtWlgfuHt2nbvdT1RTnLlJAoDwPE5+CyouE1D17VZ0b3Jod1+hymOeUxnPrd0iwFuPbN+9Rhfb9Yxcu8n\/wBhqvWqg+qzg1l5qimWJXdC9YkzbxONUTfvK9kwPQ9zso75UcNPfr+TEpMbrt\/BRtaOJNx\/4SQu9B3bnLnJ8uLNi6NOt365nVtD5JxSHtmf+dg4\/xb87X5M3NC6cfzvQmQI9qD9Mq1zn+0gjHPq4655yd1u5nhg4EMmaEs3fZp088OiKw9iNWlCKCTEJlAR2b2INEIoCN1EAkJqaRLSISHirIJAmg2AIUhwZbu0HJsZOoqagc1rrDOl7gB58HUJWJrgExsDBMPq3408cXavhL4TfLX1ku3WmmwUMI+rg6Y0Hx8r47Thjbu2mV6Gsz6k0GbFGoDy+jBTh43WHUM+py3l\/dMF+tDo7o6roO+fPi4ymDKAtfdB36rQ5+NSnmAhMVEIw\/pHbGRp4oFzb0RegMbEftoFEN1HI89\/qUOIiERyS9IZmfIvje6TNfJh48eNM\/TKQMQ7J+\/yIaK\/7Vfx6DayvJO8W5HeNeo\/NjgFWGkXCbI0A9HMUd+bAN9RHvvae557v00HFftcW0YClWr26dxj8Mz9cNfgvFfluIAyX8Ltlwa3QHScaF1ni2qzvSbKLuPPgdT+oeel74Hw1XlNy6Gq20eFDrxGSSPjW6bzFoLjwkyvNAFRrvgwb9H24ajEuD524UfzjujebyyliafA0vt09jiUKYhh2JBBynrWKmaaxqcsqvwhk16DUtBhr0qGZ6M0Jz8jV\/WqyF1EAkJ+QVxj79swX6AmL54HthGd359CY6D1hjhmzfhEVFHGWkuQ1FDGCwGVRwaHZnLxQDZORiaeeh1L8HM4KoRnLvbmoYTa7vURTDw49Dzv59xHqhlehpMvWBfpqQpcEiYL196KRxTOY8T5Rz1CCxtZ87D\/gnQ8Afj9KpdgG8C9wW7tMFs5qyBCYL3xgrCwcCLb8KKbs7aZMPQoM4h8rDUGY2t+dDKwaJQpeHAxzH4BXEquBHOp0avrpIXYRhUHSZql962gVEAHUX+qTqdvSnk3Z0d0ekHL9u2anVnCnm0+lvqIBISsaqDbF4Pr1V3VqbV9ZB20n7+h7c552vWXqiaErhfPgq2qpYPx++CxoNcfPnGK\/lq8C082Nd7OcyweChgl2Y\/FDb4AD\/VMeEp0WbfHA\/\/CxwTiLQ9iF58EKtrUo77+CBW1+n65vFB9swKpRf8N2CnUnwZxQcpTs9tYG0PItKzawMjxgf56WktDfHKmhd524xeuc5l8NIeJBqQq1h2PrNdoLa44mOQr9jhmR0\/dQrnaAuc81Tjj7HRNiVy+Mpn30sdREKiNHWQXwou9IEFxfP199GNbbFAmM9X+R5G3eysjkWvm+sUaXeBb1905S6R6XMs43nIARJDOCB01r0fmzt2c4or2yvpF94IzVUvx\/Q0GLEp9Ny0nXKFs9s+KIn5Mw4OqJwPdL5Vuw8y3uIFHNwgNNMZMCwYZz2InLrOnTbMWQOpwqHQpjnK9NXJ1n6sxHa6Y6T2LJWYvvAVZ\/YgcoC4QJO9lDivxmPn1ZXGQhOho782cN1X7BEwbyCQY8HvVtUPU93xWKse1BJo5twUZjsGaYQbCqHJe4RsNnRON9dtJ+xrbIu990jqIBISUgdxh28qwObRka3jzTGqHy5xTuPTfsAYg8TmOLIH0fB1B7DYe7nfqybwPMZZ2cMz4T8\/Kn+7\/CdvQ2\/IAWIDe3IhxeIsVtY8+I0wX68hKBy+v8BW1dmr+M3Ar4s1XUjRefm25ofu7zugdRynRorFC7xpBFRcZJzeQWXMpLbTH5UA9\/1knL9JGrz9vHo+6oBnizYAaLmYEmd639SDFFWUouUprt0JyAESKbQXXwbxQF0jnQWe39igJ7wMEeFRwN7ZzsobhUloX8lbfi+5SqWfjYtun0odRELil\/gFWfcUUDydGBDduovawQbVfNr3MHQ+I\/AnTnXio8NXXkdlvS36Q\/1kj9tdNYUrDv8d1b4XeKibDa2+iOEB0maS85gPtU67r1cRYP5+d7SuzILVFjYnjQXbj5PHtQHuU7fDK8UD6HLo8T9letIUeF1tPy1MJ+beC4UCD9k69iBmPJ79QcvTqoHQp3gWON9axmoWexQHX4Qeqv0cfz9KlnmffgyKhDoWJ2ptUNQ81DWpr\/VUbf5ey4CVoeeMQyUxP2NzgNS\/EuovpUyj4dTomJn3NGmnHmuVz9k69iBXrg5FmFLjHYt9kMRT0DPC8l2viia1WMcassNL9oN4Jqt43jVE6iASEuVDB4nEaI4mCnc7k6FOEtTLtNkmHYH\/uWwznZ32H38LPwo0WtaBigvs91Pyp5Ac9FTprwi7Vbpb1TbQbJrD92CSasptsUdxdBiYeThtluXMj1ZMDpC2r8beC788Rfmc8Km3MmTNE85W6WCpzlmssVNCz0PmQlsnFb6qlGl3TWirF0DHhITazj7bB8WWxj\/6tW0wKgGyprl7F4oKzV0HWbX71peNz0TWHQfLC5S\/Nf0CaBxjAyQWkfKQN2GSvcTgFcGbBTBkpfPy\/SqA7\/XA\/YwRcjqU1FVoU6mDSEhEHnKASEhEcorV5kxgrTmaqNyP0N5GI3v1V\/wDYKB3tGvmXoZfC4fmEhpBhsXmVNUngGIfw+Mg4\/dhtMOlQHCK1eFZyHhMmV7969B9o9rWMl4m2BL76kDGZmV6PcG+peLk8NqsguB8+qZH4WqHOk3thkBu9N4111FuJSTkFEtCQg4QCQkJOUAkJOQAkZCQA0RCQg4QCQk5QCQk5ACRkJADREJCDhAJCTlAJCQk5ACRkJADREJCDhAJCe\/x\/0xetREQrLIJAAAAAElFTkSuQmCC",
        "url": "otpauth:\/\/totp\/Arena:vkarpenko%40arena.com?secret=GZMFQWCYLBMFQWCYCILSLIA2RMOIQO7Z&issuer=Arena&algorithm=SHA1&digits=6&period=30"
    },
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`GET core/auth/2fa/secret`


<!-- END_fe187542939033fc5ea215563f29e0e7 -->

<!-- START_70239d911e40387216d5c2ce814c9f36 -->
## Generate 2FA Secrets

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/2fa/secret"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "secret": "GZMFQWCYLBMFQWCYCILSLIA2RMOIQO7Z",
        "qrCode": "data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADIEAQAAABXwbpWAAAABGdBTUEAALGPC\/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0T\/\/xSrMc0AACbvSURBVHja7Z15eFXF+cc\/IWy5YRMSdqFCWQSRVSugWEEUl4LVsNYAGpaggFVAAVksYBEjVQMioWqjUFzA9udW3MAKAtYiENYCorIpGjYFAmTh\/v64N7lz9nPuOffmJs73ec6Tc+7MvPO+M2dy5p2Z933j\/H6\/HwkJCV1UkE0gISEHiISEHCASEnKASEjIASIhIQeIhIQcIBIScoBISMgBIiEhB4iEhIQcIBIScoBISMgBIiEhB4iEhBwgEhKxh4puCfzrf7CrWnSZrtwPxn8Zvfq21YQPdyp\/6zkROr1mr3xhHDxzyDxP3Lcw4drQ8\/zPwP8rZZ4JtSHOF7jP7gTH3lamj\/k9JP5Xn\/7mQbDmKWdytyyCvk0D9\/nPQuZdFv9tz8BDrY3TMztD\/lvRfVfanIFbW7sg4HeJjEN+P0T36rjQH1WsOqbl4e3e9sufHWAtU9IUZZmkKdo8ha1D6anbtem5DYx5eLu383aesyZU\/nR96\/xN0szboePC6L8rGYfc9b2cYklISB1EQqKUdJBYwKv9rfMMjgeCOsOqM3DqHnd1nqmprLfFy9AlqB+cPw3\/vNelHC206W9cARTnmalN\/6i7kK5GTZdtey2w0nlfDF4hB4gGOwd7S6\/tqyaJR2CIjY5L2QCVgvf\/VxeWnHPHk7rOrKugy8PBwdMKhnyvTE\/dDpP\/bCLjXBhi0o4jZ8EQcdCstObJKbJ9cFU\/gaeeyvRRCfDAHSYyvKiVYfARoFGMvCux9AVps9wbOudTy8\/n2rBNFgA6HdumKzAu+PBVdHn8Id6hDL7w6msWD1WXesP7riFSB5GQKF86yNFtsCvDWZla6dCpu7d8rFsELIqsrGuKv3a9gGUm6TGMEh6H6MtQgrOwJl14vssivw1sXg+nFjv84k2C+leW4QGyKwN6OWy4SZOgk93MjWDtc+ZZ\/jQAeiWb5xFpfD0JhucZpwP0uF\/5PPoRc\/pL24GbmcRT\/aBQ4OGvPQI0zXh0ih73K1\/yOWugx+7Qc2Lv0H3BNuf9aoXXqkOGQ5qrgfpLy\/AAiQauu88iwzFrGi3HQb2i0ABRo1I8XDM6cP\/lyOjL2FW1k\/\/XHdo8l8+BpO\/Co793dphtW84hdRAJifL+Bckp8EBXOg9HCyJfjyO50gEHdR45AEeE\/G0mQKVM\/bxnFsF+8Us4GZjhQOYucoCUDRyBDo2ts61MN0773wDoUNliipMOpNtna3oatK8Uek5RKZ\/d9sFD843TwZonUaacAm3+\/ROgmUHZHfHQVZU\/2wfVhgo89YRpJvX3yoUx081lkAOkjKDvUKjUVT\/t8U8iU+ddzwf+5g00T2dBePRvOQG+14MDZIS3PBvtgxjK4Cuf743UQSQk5BcEvh9jkvh06fB0sEP06jpbAMevEn4YY8FTOyBHDpCyP0AaQaZFR77VEJqa7YP01P6kpjm+vXkd6vy\/EjYlK\/8GMh9V0WsBTaPYTGtug74ij+lanoe3Vw6KOWugRh1jmr4WwMngQx5kbtPvHzlAShnjLHZS3zrmnObNb0HLoAL6\/nHr\/FXeh1EPCz8ICmvFh0JHqgCKLofxMdBuLRpBn+AAMNoHMW3bk876QeogEhJyihV7OKGzVl+7UmzxVPE5qPFHb+s4vwzOFzhvm3DlqNQbqv\/bmHbcILjkTTlAHKFWeuBslRO0ul77+TbEEaijsw\/iTwjMiwF+eyl0EubWP13j3h5kkmr+3vBvoftjDSFZxx7kleLP9iXa8lZY74MNKiOqOhb7JM3nA\/Pt0fe10PI0rb1yH2RUAmQF7ws2Qp1uyvxN0uCAizZtdb3zdql1uowPkE7dHRw8NJjbusU01WAY7QHN6ybC7z4UfnCwEha3AZ50WF\/3CNuDNB6k5OmHeMggukg7ScxB6iASEqXxBYklS8ALM8D\/TWTrsCOvmCduN1TZZF6+6tLotpNTGeyk25Ehlq1GIzJAvLYLdovbxsNq1T5If9U8a0VW+PS\/ngjNl5nTV9uDdNsH64sfFkCCjh2E\/2qU68M4k8GJjHtnQysLGZZkwRIhT69cqD1NST9BLcMTmO6FJCwjpvGL2UlX46W3oFpQkX78E3cDRA+tC2HWC4H7vIEQCece2SdDZ7Fm6JzFeqIaNAt6U3znJuc8tB8Ij94QuD\/TQL\/8G8X7PT6IK4fvidRBJCTkFyQ8XBwQvHk+wvSN0tcB64IPf7agUSO8OjyT4XYi85ks6wOkcj\/ouDC6TNfJFx6qGdSfHbqtkaST5yZBhq3a9FZjxcm79zJsaAFWJ8rjVyh5UPOYOFb5rE5vbpEe\/zNQJ3wZVidby6Dut2i\/K5X7AW4cnfslNMj2WTtFFp1X75+gTZ+e5sx5tZ3LifPqrHna9E0jjGXeM8u982q9y3+4bL8LUgeRkIi4DnLEY64aeUC\/URRkOFIGe\/xIKdcp9osf+M5h3ztNL+0B8tRhmHSpt0xNyoEng0enz6eGt1YunsWywuOfwDSVTYhvkHmZvq8BjW0yU8WaXt5rzuSLu1+H5ibzMl1eAF4wTtfQ6yHcVw1PhjhVGxX1hwpvBO4HjNEurx\/PDx00XbBNa4ezNT9k679ukdY\/2fIUbx1my1UsA2xpE7IHUePLkc6cevhegbNmGRZAnMMB8vKn8LLHMi96G4YZMFrtGwsZ5D6IhMQvD3KASEiUtSnW65nwujB\/d4tbR8JOv\/K3nYVQLdte+Q+AUSO8k6\/oNmjWwHm5Zt0BgY\/dHcF3f9l64S6roZQh5uF6objI7\/cnhK7lKdq18LXPhdK35jtfS+8\/WlmHrUtAr1wtzdP1xSib5uUNg3gG81rtg6hR2NogiKdQv14QT\/V1doBF35i0z8bFWnrZPpfvgkWf2AnieTw\/RC4zR5u+VUhf+5w2fXlKrO2DVAiuFuVZrBpZpVshz+HlBL4wy7uVyUxGr+nlRYC+0z6SOoiEhNRBFFh0Dv4hrv89jyZ+3p8GYCsEgRFOzIEbhfI1kuAfFjpH\/lxzmndsd8fTs8vh2eLyk9HYfm94QsnzFavhmYGR68gnH4APp5vnmb8Q2j9mnL70ACw1aZPOHWHeodJ9YSf8JDwMAFQ62IvPw4uCDHcmwn0JpThA8o7DatVG4c7B0CJo6LNukTZ4zcr0gK9cCHg8bGphqK82duq4UNswivr9cFBVJn9D6H5sL1iS7E7u1cnO0htuD93H74b8jaoCtZWP3w0Dfmdeh+hr+MxZa54KR7iTqXmCuzb7Ihv8GyxkquSMx9V3h2KY7FsAbVXpfQ5hf0M3mqtYJZ23yLpzo4XSqDNcXiq1KofTlf9GuC0XeE\/btQ4ysTESElIHMcJTh8uGoGN7xQ4vFz+CMf2s82V9D9QMzr07wJm9MdzAb8FoGzHPF2cEzpHpYWEl2O7Q4d\/rbwauiMHtOnHGIe1a9M7BofSLPQJ7DuJVuDKUfqC9tvykHG0ZxbXXnKcmadbr7SK9OWu06XtmGde\/aYQ1\/elpyjJnz5jvg+jaUmSGynTbZ50\/t4F5u\/lFe5BayjQjexAxT95M8z0QOzIV9TcmMSnHuvzW\/BA\/RvsgIs8XnnH3fkd8Jz3uU6gWRrlq30f+n15JHZ845GFk7MgQdp0nVf0yO3ZksC3josjzLPdBJCSivYr1z5HwT7thzZ5GNz5HpMKihYMtc+Ff1wg\/DMHUrsIrPH6F8HWzYXOT9Xfjr6ElrjXgwYReYhz88bfOqpk7xoTHOjE4QtzqID8n+\/1HK4QuvbNYVldmjpKGF\/bbIj2rs1hGOojZWSz1lTVPWeepaubtJuYNV2ax\/PQ0b9rNydUr11wm9WXnLJb6OtBeSaPonlB9BbW1deTd6O1ZLNdfkOo\/QnXxh\/7h0alXFPh7ogCo7H7g16tC6PzPsej8symWwXHeBYQVUad6SshxXCyckLWU\/zlv6VY8DvUiLJPUQSQkIqmDrF0H3\/Rxz8jLieW3kYuWwjJVjPVK22FIs7Ivm1W\/DTvrjv4n+wChjpsfgvoGK265jeBfp5S\/XfY+9LiuFAfIF5fBJIujzGufg3rBOH\/nJmsD3lsFyOw\/GuYI3ipazfC2k+\/dAP1nKX9rdjB03\/1d2DPLnEbtx4GH9dMuvAvDVW3U7WJA1wdgHOxRdWz3c3Bsrn0Z0t+Eu2fZz3+iLnRNN88zZw30\/8w4vVUyrLaoZ9gRHHkaEdv5g37BwKICts6A+gZlc6+H4SrH6RmXKX1PxMQqlh6KHSDkFLgrHwlXmg0eBTMDv+rDVHqWHqZ70z4lmOqsfEOHwWc+zwqTryAKNgIzvO+LpMkhryYfbCv9L6TUQSQkYuEL4hYloZifx5av3PcPASbhmz\/bYZ7e\/d3AlwPg8CWww00ItEXAGyYyAXGPws2LvWuv3d3gwDsmGVKAdAftDtRoC92OOuy3qubtrJmy\/ywHiAaZOXDVRuP0runO43fckuQufc+s0LRqx1fW+a2Quh3uWy\/I1AJuEacWUyBXeH5nJtDUnKYv1zht3R0w2iHP2T5o9ReBR9UG7qgEKI7bWakrbLQY0L3+rW03szL\/6Oq+ncvtF+Qag8iasRyeK1wZiy63kbcK3kQbDZPHH+LD77MS\/Fv709WrQ54VNQNkW+z1mdRBJCRi4Qvy5cgw06uWTsOcPijw9ETptFHnvxrn3fkwnFetXHVsBRUmesTDveieNzPrx7iN0GmHOf0tNTE+DT3OGa8\/NYWvhDgvRGAvLc7v9\/vdENg8CI6cCD2fqQlDVnrLZP\/RkPq1cXrfj9zX8Xbv0P2J9dp9CzHdDg\/T0+AqYS+l2gW44dPQFKvi\/6x58mcavzRDdwQCg4rIbQBJQW\/pS56E0Y+4k8EpmqTBAWFQJQ527pTbrF8Aur0AdZoE9Swd59VqZBxyZ\/Xq+gvS6TXoJDy\/2p+I4HcfGiQcwZVRvjg3Lj7zo7c7nHyX8Zz764nARw54LiU0bGr8Vdo7W1+G0kb7H6HJVqmDSEiUTx0kdy2cfjvyjH49sfQbqzR5+PZluCi4DmK4Ns\/PQ+DnYh7rmtO70BWOdBd+qBmbbVR4ownNZmVggLzcDCapnKZlzVM+q+fC6nQ11PlXZEU3gGrrUZClOnvSNd07+vHXQtY95jKr8YfusEEcFPOV7Xh4LzSfb5+HLcO1Mln126gE6PyYeb81x5jm4kTYMtb+u3ChDzS3OKdn9S79+keXU\/BIO21Yfbc2fWW6Mb3j+dE3\/Ck2PjKCHYMpJ86rNcgMz2mD6LzajsGUGMTTynm1nhHXqATnThvEIJ56BlPn7jZpFhtOHFbfLYN4SkiUXR3ECMcaBm+s\/FF9DMeGxkZjlPAMJIE2wKRHtAHiZkIdi53oY3OB4iPva7Xpeesgr5jurQ75mOmNHCWoBZyTA0SrJ10SWPMX0fZF4WGZNr2esFF0cCI0VblpmZQDVTPt8zD7Re1vYp0bnrD2O1v\/IiDwsWcWtAzeJzfVyqCuU53eWli4yBsIySoZu\/WC9RZyKcq0UNbx7R8hWdwHsWgDCAbxLEa6Nr2RsMlX1QfTB2plXlLKg0DNc52\/AUsjWKHXczbDADoGMHIcZxuHDea+CeYBdKwu0WmDGnqO47LmGec\/O0Cbv9s+ax1EfRW2DhVJ3W6df\/+EUP63e2vTVx2z38yn64en23mtg4gBdKIBqYNISERyilUYB\/kRsPLLM4mlEbcCEi5alP8dUEzjOfc8+NoB08Ln2QtcuFKQabr7dowGz1a4mK9q59fdyySi8htQ0V+KA+SZQzBJ5dQsdbvy2XcNcJ9++Up9IHWZ8reMdpBhUmfHhbC5ZOKsre\/TZyBRnJPrHK9Wl1Gfa1LbvW\/sCddgvgdgpnOr66sxE\/h78CEFUm9Qpq9arrVJT3xDKZOaphrN25mnO7W9sGqzJmlw\/R9VhQR79Kt\/hCsEGucXQqLKzuf4spDJrR46OHQJlXEIXO1dRnofxCns7IN0XOiN82ozx3Hqa+Nicx3E6krd7qwd3AbxzJrn\/V6RuA+Sv0Gb3iTNmYz9RzsP4un0yjgkdRAJidjVQcKB2qIuvgqw1QWNihC\/PYp8X+t9G2jwe+d04nfH1stV1A4oVPX1bgcyvf4LHCA5BdBBZQuRmRMye6gwBLrtM6exoYWScd8gEP2TNT8Kjfdpyxih6rXaOtX5FeeWbNhyqOmJOoctexAbPrESVbpVbsOQPUjl\/tDtTmd9o5ZZLUO1FGf0alyhtQcpGhAyua3ZQltHHVHHaG\/vXTDjueoTwMIypINszdd3Xm0XRf215X2DzMtYOa9WI9vnfu5rdhbLbgAdp1dug\/D70SiAjhHs6CC+Qe4D6Bxob5zfKICO3AeRkCjzUyyjiKPpDvO7rQ9gcCm17oIY7\/0FMVDvuHI+QOK+Dfh0EtF2LvCqQYHx2vzj24fl\/b8Eea9BnJnts1PiKyBJ5ZPWiZ9cCJxbmm2Srm4DT7DJftbPs6DreHOe4sx8LtfW5q+cY11v\/AoUxj3nvoCqwbNUcVfotMspE2JjIEkdRNbrdo3GWSwzexC9s1jRuMx0EC\/sQawuxVmsUoCVPYgX0NNBnJzFigVIHURCwgRygEhIRFIHmf8ZPPEv4YcWZa8R\/vwePK0yzljfF1peEyUGnofkQ86LHTgPvqAv3ZkTYFEVZfp\/ukGz2wP372yCe\/\/hHcsFe6Dhy8rfauXAvvfCp\/nIRXjJ4kDo6u1w5TtlaID4f2WtwK59Dq4rsr9yMSkHnvzUwUKBjhLuTwCCBv03DjY3mPL7dGRIwPx0ogWmp8EsM4cDXwG\/Dt4XOl8EAEA4Re3\/CY6pjaYmAMEBwlQ4pvJ7teoY9Fke5orSCS3PPpUx09nuhLxdG0Go07\/Duh38+WXsC2Ib4yKU\/4jJKlUxjWOUDmJ8CTPiPI6VOoiEhNRBoo31Puj+Vdlu2NWTYbWJDHUvg3\/Gu6uj9+PBqRrAZDR26anpQvoirX44+2TgsotrUmD+VvM86n5b3wBDp9Ij58OufuIczZn8G9vCxLeUvz24C1L6etiRbteJL54NnC0yu6wg5g3HL5ZvkHmdVmexLr5vXt7OPkjWvFDZ3AbO90Gs2lDPL1a0Lyt7ECubdDv2IHpnsYz6JRpnsdzvpPvcH7NWlC\/wgIZTGW725qh4CY2GEeC\/jH9RPXs\/pA4iIfEL1kH23A+Pj4lsHfdOgcI\/CD\/UN8+\/5AP4TBXLe1Y+\/KqT\/To\/uzUYGBTgQ6CddZmhOxwIVbX0X5ZzXwg8V3dePn0m5DkMjzFtGWDUTj3K4QA5\/wwsdWh43380ZJspkyoj\/9W5cLCdffq5lbUOCKbNoiTwyc1ZcNbEc8vRS60dJKRuh8XC6cXEFrDBYduJPKRP1w+g47sucL+ss9b59KYRcLlBFNnDV2gdVcxZAw8Gg25eXAvVVfX1yoW3hQA2iW+Y8\/9FXdjSzpnMS9uV7j+FMhMG2leK5pdxUy0WWCY6k8FOEE89VNkmzMd3WLTTkw7bcbZ5\/jMNLOj5KJeQOoiERGl+QXLi4c173NOZMSK6DbPsACDUOaQjtA5OJ75qC690LXud\/ZYf3hpRvl\/o3TWV70qHZ+FON8E9I32eXi8+iNU1KSewl1B8Rdoe5HQfZX16NulWfrGy5ilpqK+TtZXtok43sjEXLxEna5une+EXS7RJ1\/PN2yvXXCY1T8damLeRkU26UX69fRCv\/WLFrA5S7J3jfCqwLLJ1VVsF1cQfEt3x7DjvAnTPkyVNwfCsVK3jsdtnRqiz14LANod0F0kdREJCrmKVBpY\/qFzp+cMySNzmjuYSgd6lt8EtbQ0yjoQlNuxmlpwzXo0CSHsG4oP\/XVfthEPvxVYbL\/kAUNmpj7oW6yPwAt4fomyD25tDw7uiJ0Oc3+\/3R7KCNanQSzVFWpkOHYVpjDr45KQcePLK0LNV5FS94JX7JwidMtk6gM7RCqE46SfPwUmV9\/RG66HKxsB9fiocrmfOw\/Q0mPWCfl16juOSpsB\/BFuH31S2to04OyC0zDpjhDaoj9gGO7dBX4s46Nk+uE7YxK12Cuq+YNwP8Seh6YvG9BIH6ziO6x9yHKfG95\/Buf8LPb83NODQQ8TWfGgf3Pc6Xxm+E6am57+DtipnIRmHYKKLIJ6l9gVp9lTg78EO9vPq4gigM0CaLQKKvXI4tAe5JAEuMamz8lJlBGKvQh8r5JzqLc2dN4XBg5N+8AANrkXp1tXii141X9kPu4ZIHURComzpIJsHwZETyt+u+9J6leWd4v9oFgHv\/Zvh3cmqT3snuPWJyDXKrr\/DfpW99dXHod6XgfvcRfD5\/1nTecfov\/al6Pr3VeTv4l6OndvsfznUuHAbfKg6WV2jO1w\/04G8dbzvm4O3wcGyNEDWPKUNoLNzcCDoKUDHvMAZIBFdFjvoqKe1c+eO\/WwHdTWEmqekPqH7\/46C4SqnaRsXQ7HacXCLlqesedBZcJzc5QXz+rvtg8x5Qv65oLDz+ch95\/Z1QePU+9BXFcVr1GcmA8QHfc9Zt3OFvzrgvzJ0E8p\/WxH6Wrw7y1OgZa3Qc+3KpTxALOfzb0Jn4TmnAHih9D+drd6Fat97S7NzsPOPNXSWP+ZdlLppk8dQRJlygqatoakwoL4d47BdpQ4iIRHjUywrHO8O+4aWj8b6PEvQD14wSZ+JsZNuvfxhTgO29QSyIiTjIn0ZPjeq72l7MovYshEuWKxUdToPlR8owwPkprZwhWoZtZHg0yqnGfSyaLjMHGghfIZr\/wsI7oNU\/Szgv0mhpP\/sjMepr8NEFQ3fLuP81\/wHVqmOd3e1CHiptr1QI3U7DBFo3pIEVucdV5ksTy\/\/Hrq2M85\/8EUtT6sslrtvSVK+5HPWQOcrlelL0r17+ea+DCssBviB9tAkOEA6ZWllcBqINOoD5MqfSt7lEO50TqePuOKRKtx\/A31wtzrS836dH68z0U+ugFbC8\/senXsqltGuPUif5RiexVquoz91aRc6t7REp0zyZOP5+d7Z5jwb2YNEE5ddhMuE53XyLJaERDnXQbyA+r9bhdfg1zu9o\/\/943D6okmG+0pJ7lMoLP1aTjfPf2IMnCjOX8XZlyJiMrykfLaSQY3zdyl5\/tWHUHldOR8g2SrzzBY3AUcNGigVWqnOcnVcCJs95OelbjCtp0mGGVqe1fskWfOgyp+MSdQcBgQ3GuPvh2wLnWXiA1ob8cLlIZPbO4dBL4Gn\/YO1+dU8d3GxvF71Hsh+1jzPcJ2AO2qeiraHzmINbAG3mZjq\/rwRWumdxQreNx4B2ZOU6Zdv9PhlLQ2DKTGAjhXO6ZTvuFDIcNjAYVmC\/TrmrLE2vLFjMOUlkqZo6zBzwjc9TZt\/\/4RQ+tu93RlMWSLBHk2zIJ5qZOoYUG3NlwF0JCTKjw5yui7kma3yGJyw\/MHEL22VWtZnuX6w8Gv7wwVAyFOvyH1jldR5r4e0jGAxBTs+EgrF+f090X95foj3lt6pOnDhlPDDFvP8hXXg+CnlbzV6QsJHMTRAsjZrz2IpsCywni4ipac5zUmfhGxkKj4Ac1Qv5LSeSl9wvkEwdVToecnfob7KTiF\/I1Qy2Hi4\/ISWRzW6ijy7PCpTdDnUv2iRycIW5MEHYKnIx4vm+evfDXOmaNtRhLoNLj9hTK9gow0ZdGhWeM44758\/gQxR52hvTnvjbOihWsJfXsvboMZRUdJ77IbrgitBOQUwzQmDXeBR4fniAP3yj96gHCBOcKeFhdr7MWj\/7RRXDYWrhOfPs7Tt2Ph2GHbW23ofbYnyLNYNZavdpA4iIVHaXxC3sLOLq8hzmzb9wp1wwUGd1b4mEIYtTD4rdYIqHtuInzsFFNfxkXOeqt0O\/NXbdneDvIfgomgi+8EvZICMUr1Yib3Dp3U+FaoftWjo11S+lF9U8rD\/IFRPdlbvnqecbWqNfgRGC8\/TG8Asg7xxmTCqnzN+dmyD6qKjh3badlZDbSe\/CaXpgZUCbqVj9MqF5k2Eqe05ZzINz4MVR5U6h5VMCV9Tcg4osbc2f62\/lYEB8sAd0GZ56Y78LCixSb\/xWGz9V6rQG7LynJXRi7j19O+Mfe0ueRLLlTBP2rlYDp\/++S+nmPsT1K5kL2+nFs7bUeogEhJlSgc5CwXimX+bttYFLo8MFKwGimmEGbu9hIeW7pvBUp7aUKmVO7qVukaBT6P8q9H1d1VwEMdG5IYy\/QUKHMpYcTLEfRrDA2RNutYvlt5cVkRGMmSYpFth32So3M28DrWfLHV6q2Rghn0ezPxu5Q20jp2RNAVy\/2ycful9Wh4SkwGBbm6D0HH3hJna\/BUXWusEw7vZ76fVyUpbryZp0EJwprFxnLYfrGjWURmPHWgPTbYG7t\/cBykTnL0LGYdsR6copS+IDfT7DsYFjUpOFGjNPWpPgzccOHpoqvPbqn2h\/0ajfYF\/eCL+Xi+02\/5yojZ9zptwzWj9+r6eCM0j3Eavfah8topOlXpOaVYDwGPueGjeJDTnL9iobwj5sWDAZMfF8bsPQtWlgfuHt2nbvdT1RTnLlJAoDwPE5+CyouE1D17VZ0b3Jod1+hymOeUxnPrd0iwFuPbN+9Rhfb9Yxcu8n\/wBhqvWqg+qzg1l5qimWJXdC9YkzbxONUTfvK9kwPQ9zso75UcNPfr+TEpMbrt\/BRtaOJNx\/4SQu9B3bnLnJ8uLNi6NOt365nVtD5JxSHtmf+dg4\/xb87X5M3NC6cfzvQmQI9qD9Mq1zn+0gjHPq4655yd1u5nhg4EMmaEs3fZp088OiKw9iNWlCKCTEJlAR2b2INEIoCN1EAkJqaRLSISHirIJAmg2AIUhwZbu0HJsZOoqagc1rrDOl7gB58HUJWJrgExsDBMPq3408cXavhL4TfLX1ku3WmmwUMI+rg6Y0Hx8r47Thjbu2mV6Gsz6k0GbFGoDy+jBTh43WHUM+py3l\/dMF+tDo7o6roO+fPi4ymDKAtfdB36rQ5+NSnmAhMVEIw\/pHbGRp4oFzb0RegMbEftoFEN1HI89\/qUOIiERyS9IZmfIvje6TNfJh48eNM\/TKQMQ7J+\/yIaK\/7Vfx6DayvJO8W5HeNeo\/NjgFWGkXCbI0A9HMUd+bAN9RHvvae557v00HFftcW0YClWr26dxj8Mz9cNfgvFfluIAyX8Ltlwa3QHScaF1ni2qzvSbKLuPPgdT+oeel74Hw1XlNy6Gq20eFDrxGSSPjW6bzFoLjwkyvNAFRrvgwb9H24ajEuD524UfzjujebyyliafA0vt09jiUKYhh2JBBynrWKmaaxqcsqvwhk16DUtBhr0qGZ6M0Jz8jV\/WqyF1EAkJ+QVxj79swX6AmL54HthGd359CY6D1hjhmzfhEVFHGWkuQ1FDGCwGVRwaHZnLxQDZORiaeeh1L8HM4KoRnLvbmoYTa7vURTDw49Dzv59xHqhlehpMvWBfpqQpcEiYL196KRxTOY8T5Rz1CCxtZ87D\/gnQ8Afj9KpdgG8C9wW7tMFs5qyBCYL3xgrCwcCLb8KKbs7aZMPQoM4h8rDUGY2t+dDKwaJQpeHAxzH4BXEquBHOp0avrpIXYRhUHSZql962gVEAHUX+qTqdvSnk3Z0d0ekHL9u2anVnCnm0+lvqIBISsaqDbF4Pr1V3VqbV9ZB20n7+h7c552vWXqiaErhfPgq2qpYPx++CxoNcfPnGK\/lq8C082Nd7OcyweChgl2Y\/FDb4AD\/VMeEp0WbfHA\/\/CxwTiLQ9iF58EKtrUo77+CBW1+n65vFB9swKpRf8N2CnUnwZxQcpTs9tYG0PItKzawMjxgf56WktDfHKmhd524xeuc5l8NIeJBqQq1h2PrNdoLa44mOQr9jhmR0\/dQrnaAuc81Tjj7HRNiVy+Mpn30sdREKiNHWQXwou9IEFxfP199GNbbFAmM9X+R5G3eysjkWvm+sUaXeBb1905S6R6XMs43nIARJDOCB01r0fmzt2c4or2yvpF94IzVUvx\/Q0GLEp9Ny0nXKFs9s+KIn5Mw4OqJwPdL5Vuw8y3uIFHNwgNNMZMCwYZz2InLrOnTbMWQOpwqHQpjnK9NXJ1n6sxHa6Y6T2LJWYvvAVZ\/YgcoC4QJO9lDivxmPn1ZXGQhOho782cN1X7BEwbyCQY8HvVtUPU93xWKse1BJo5twUZjsGaYQbCqHJe4RsNnRON9dtJ+xrbIu990jqIBISUgdxh28qwObRka3jzTGqHy5xTuPTfsAYg8TmOLIH0fB1B7DYe7nfqybwPMZZ2cMz4T8\/Kn+7\/CdvQ2\/IAWIDe3IhxeIsVtY8+I0wX68hKBy+v8BW1dmr+M3Ar4s1XUjRefm25ofu7zugdRynRorFC7xpBFRcZJzeQWXMpLbTH5UA9\/1knL9JGrz9vHo+6oBnizYAaLmYEmd639SDFFWUouUprt0JyAESKbQXXwbxQF0jnQWe39igJ7wMEeFRwN7ZzsobhUloX8lbfi+5SqWfjYtun0odRELil\/gFWfcUUDydGBDduovawQbVfNr3MHQ+I\/AnTnXio8NXXkdlvS36Q\/1kj9tdNYUrDv8d1b4XeKibDa2+iOEB0maS85gPtU67r1cRYP5+d7SuzILVFjYnjQXbj5PHtQHuU7fDK8UD6HLo8T9letIUeF1tPy1MJ+beC4UCD9k69iBmPJ79QcvTqoHQp3gWON9axmoWexQHX4Qeqv0cfz9KlnmffgyKhDoWJ2ptUNQ81DWpr\/VUbf5ey4CVoeeMQyUxP2NzgNS\/EuovpUyj4dTomJn3NGmnHmuVz9k69iBXrg5FmFLjHYt9kMRT0DPC8l2viia1WMcassNL9oN4Jqt43jVE6iASEuVDB4nEaI4mCnc7k6FOEtTLtNkmHYH\/uWwznZ32H38LPwo0WtaBigvs91Pyp5Ac9FTprwi7Vbpb1TbQbJrD92CSasptsUdxdBiYeThtluXMj1ZMDpC2r8beC788Rfmc8Km3MmTNE85W6WCpzlmssVNCz0PmQlsnFb6qlGl3TWirF0DHhITazj7bB8WWxj\/6tW0wKgGyprl7F4oKzV0HWbX71peNz0TWHQfLC5S\/Nf0CaBxjAyQWkfKQN2GSvcTgFcGbBTBkpfPy\/SqA7\/XA\/YwRcjqU1FVoU6mDSEhEHnKASEhEcorV5kxgrTmaqNyP0N5GI3v1V\/wDYKB3tGvmXoZfC4fmEhpBhsXmVNUngGIfw+Mg4\/dhtMOlQHCK1eFZyHhMmV7969B9o9rWMl4m2BL76kDGZmV6PcG+peLk8NqsguB8+qZH4WqHOk3thkBu9N4111FuJSTkFEtCQg4QCQkJOUAkJOQAkZCQA0RCQg4QCQk5QCQk5ACRkJADREJCDhAJCTlAJCQk5ACRkJADREJCDhAJCe\/x\/0xetREQrLIJAAAAAElFTkSuQmCC",
        "url": "otpauth:\/\/totp\/Arena:vkarpenko%40arena.com?secret=GZMFQWCYLBMFQWCYCILSLIA2RMOIQO7Z&issuer=Arena&algorithm=SHA1&digits=6&period=30"
    },
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`POST core/auth/2fa/secret`


<!-- END_70239d911e40387216d5c2ce814c9f36 -->

<!-- START_1050578282044a505ab2a3b0c63752df -->
## Disable 2FA

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/2fa/secret"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE core/auth/2fa/secret`


<!-- END_1050578282044a505ab2a3b0c63752df -->

<!-- START_2d0e1b9d8857fc3e5f0a659e7bb21fe3 -->
## Verify 2FA Connected

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/2fa/verify"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "auth_code": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/auth/2fa/verify`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `auth_code` | string |  required  | One Time Code from Google Auth App.
    
<!-- END_2d0e1b9d8857fc3e5f0a659e7bb21fe3 -->

<!-- START_bffcfd6d4e180c84097dcf80b746f7fe -->
## core/auth/access/group
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/group"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "app": "molestiae",
    "group_name": "ipsam",
    "group_memo": "consequatur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "group_uuid": "81558668-52B2-4127-9373-8FA9B86DAE1F",
        "auth_uuid": "021B118C-EA54-4FD2-A8EF-3C99D4D1C862",
        "group_name": "Today Arena Group POLO111",
        "group_memo": "Group memo",
        "stamp_created": 1584250801,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584250801,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        }
    }
}
```
> Example response (417):

```json
{
    "response": {
        "error": "Can not finish your query request!",
        "exception": "Illuminate\\Database\\QueryException",
        "message": "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'Today Arena Group POLO111' for key 'auth_groups_group_name_unique' (SQL: insert into `auth_groups` (`group_uuid`, `auth_id`, `auth_uuid`, `group_name`, `group_memo`, `flag_critical`, `stamp_created`, `stamp_updated`, `stamp_created_by`, `stamp_updated_by`, `stamp_updated_at`, `stamp_created_at`) values (DE169F46-94F3-4DAF-B774-9A07EAEFA61B, 8, 021B118C-EA54-4FD2-A8EF-3C99D4D1C862, Today Arena Group POLO111, Group memo, 0, 1584250817, 1584250817, 3, 3, 2020-03-15 05:40:17, 2020-03-15 05:40:17))"
    },
    "status": {
        "app": "Arena.API",
        "code": 422,
        "message": ""
    }
}
```

### HTTP Request
`POST core/auth/access/group`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `app` | string |  required  | 
        `group_name` | string |  required  | 
        `group_memo` | string |  required  | 
    
<!-- END_bffcfd6d4e180c84097dcf80b746f7fe -->

<!-- START_08b5e9ba127e4cce5e2965d8a47c7abf -->
## core/auth/access/group
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/group"
);

let params = {
    "group": "modi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": null,
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": "Successfully group deleted."
    }
}
```
> Example response (417):

```json
{
    "response": {
        "error": "Sorry, can not excute your request",
        "exception": "Illuminate\\Database\\Eloquent\\ModelNotFoundException",
        "message": "No query results for model [App\\Models\\AuthGroup]."
    },
    "status": {
        "app": "Arena.API",
        "code": 400,
        "message": ""
    }
}
```

### HTTP Request
`DELETE core/auth/access/group`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `group` |  optional  | string required

<!-- END_08b5e9ba127e4cce5e2965d8a47c7abf -->

<!-- START_00c17a17581599e25fb97d21644d774d -->
## core/auth/access/group
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/group"
);

let params = {
    "group": "iure",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/auth/access/group`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `group` |  optional  | string required The uuid of group.

<!-- END_00c17a17581599e25fb97d21644d774d -->

<!-- START_e60c4d2fc0464c82fef118e33cad7257 -->
## core/auth/access/group/users
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/group/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "app": "consequatur",
    "group": "dolorum",
    "users": [
        "aliquid"
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "group_uuid": "4916F35A-83B7-445D-AD49-145FE1005256",
        "auth_uuid": "021B118C-EA54-4FD2-A8EF-3C99D4D1C862",
        "group_name": "Today Arena Group POLO",
        "group_memo": "Group memo",
        "stamp_created": 1584250477,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584250477,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "users": {
            "data": [
                {
                    "user_uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                    "name_first": "Yurii",
                    "name_middle": "",
                    "name_last": "Kosiak",
                    "stamp_created": 1584179854,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179854,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "aliases": {
                        "data": [
                            {
                                "alias_uuid": "EF03A768-F9CF-44BE-BEC8-3F1830E9CBB0",
                                "user_alias": "yura",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            },
                            {
                                "alias_uuid": "BDB0DDA5-1E3A-4512-9B02-630830AD1C2F",
                                "user_alias": "ykosiak",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            },
                            {
                                "alias_uuid": "CCCB2357-C654-4650-BF29-BCBB53DAB47E",
                                "user_alias": "yurii",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    "emails": {
                        "data": [
                            {
                                "user_auth_email": "ykosiak@arena.com",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_email": 1584179854,
                                "stamp_email_by": {
                                    "uuid": "4C6AAD53-70BA-470A-A854-0F88DBDC9E2E",
                                    "name_first": "Damon",
                                    "name_middle": "",
                                    "name_last": "Evans"
                                }
                            }
                        ]
                    },
                    "avatar": {
                        "data": {
                            "avatar_uuid": "C9E78A26-3734-4F4F-ABE5-727F4441E6EC",
                            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                            "stamp_created": 1584179855,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179855,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    }
                },
                {
                    "user_uuid": "7C619A2D-9BF6-4F6A-BE96-17285A354344",
                    "name_first": "jin",
                    "name_middle": "",
                    "name_last": "tai",
                    "stamp_created": 1584179854,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179854,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "aliases": {
                        "data": [
                            {
                                "alias_uuid": "DC9FA4C0-5F2A-47C9-BAE9-338CC77FF917",
                                "user_alias": "jin",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            },
                            {
                                "alias_uuid": "435B4D26-A64A-4379-ACBB-248FCEA756A8",
                                "user_alias": "jtai",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            },
                            {
                                "alias_uuid": "EAB01D9A-5FF4-442D-8543-121B595885D3",
                                "user_alias": "Jintai",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    "emails": {
                        "data": [
                            {
                                "user_auth_email": "jintai@arena.com",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_email": 1584179854,
                                "stamp_email_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            }
                        ]
                    },
                    "avatar": {
                        "data": {
                            "avatar_uuid": "5BDB32CB-F8AB-45CC-B6B8-40019DC8C172",
                            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                            "stamp_created": 1584179855,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179855,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    }
                }
            ]
        }
    }
}
```
> Example response (417):

```json
{
    "response": {
        "error": "Sorry, can not excute your request",
        "exception": "Illuminate\\Database\\Eloquent\\ModelNotFoundException",
        "message": "No query results for model [App\\Models\\AuthGroup]."
    },
    "status": {
        "app": "Arena.API",
        "code": 400,
        "message": ""
    }
}
```

### HTTP Request
`POST core/auth/access/group/users`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `app` | string |  optional  | reqired
        `group` | string |  optional  | reqired
        `users` | array |  optional  | reqired
        `users.*` | string |  optional  | reqired the uuid of user.
    
<!-- END_e60c4d2fc0464c82fef118e33cad7257 -->

<!-- START_a3a872dcc6304db2846862112172d992 -->
## core/auth/access/group/users
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/group/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "group": "corrupti",
    "users": [
        "enim"
    ]
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "group_uuid": "4916F35A-83B7-445D-AD49-145FE1005256",
        "auth_uuid": "021B118C-EA54-4FD2-A8EF-3C99D4D1C862",
        "group_name": "Today Arena Group POLO",
        "group_memo": "Group memo",
        "stamp_created": 1584250477,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584250477,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "users": {
            "data": [
                {
                    "user_uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                    "name_first": "Yurii",
                    "name_middle": "",
                    "name_last": "Kosiak",
                    "stamp_created": 1584179854,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179854,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "aliases": {
                        "data": [
                            {
                                "alias_uuid": "EF03A768-F9CF-44BE-BEC8-3F1830E9CBB0",
                                "user_alias": "yura",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            },
                            {
                                "alias_uuid": "BDB0DDA5-1E3A-4512-9B02-630830AD1C2F",
                                "user_alias": "ykosiak",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            },
                            {
                                "alias_uuid": "CCCB2357-C654-4650-BF29-BCBB53DAB47E",
                                "user_alias": "yurii",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    "emails": {
                        "data": [
                            {
                                "user_auth_email": "ykosiak@arena.com",
                                "stamp_created": 1584179854,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179854,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_email": 1584179854,
                                "stamp_email_by": {
                                    "uuid": "4C6AAD53-70BA-470A-A854-0F88DBDC9E2E",
                                    "name_first": "Damon",
                                    "name_middle": "",
                                    "name_last": "Evans"
                                }
                            }
                        ]
                    },
                    "avatar": {
                        "data": {
                            "avatar_uuid": "C9E78A26-3734-4F4F-ABE5-727F4441E6EC",
                            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                            "stamp_created": 1584179855,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179855,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    }
                }
            ]
        },
        "permissions": {
            "data": []
        }
    }
}
```
> Example response (417):

```json
{
    "response": {
        "error": "Sorry, can not excute your request",
        "exception": "Illuminate\\Database\\Eloquent\\ModelNotFoundException",
        "message": "No query results for model [App\\Models\\User]."
    },
    "status": {
        "app": "Arena.API",
        "code": 400,
        "message": ""
    }
}
```

### HTTP Request
`DELETE core/auth/access/group/users`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `group` | string |  required  | 
        `users` | array |  required  | 
        `users.*` | uuid |  required  | 
    
<!-- END_a3a872dcc6304db2846862112172d992 -->

<!-- START_4df16061ef6e5233794f55f58f032b59 -->
## core/auth/access/groups
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/groups"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/auth/access/groups`


<!-- END_4df16061ef6e5233794f55f58f032b59 -->

<!-- START_796eb599df9d7918a269d1c6d0fd94ae -->
## core/auth/access/permissions
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permissions"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
            "permission_name": "App.Soundblock.Service.Project.Create",
            "permission_memo": "App.Soundblock.Service.Project.Create",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "01E1DEFE-97AC-4895-BB40-AD03E68059D6",
            "permission_name": "App.Soundblock.Service.Project.Deploy",
            "permission_memo": "App.Soundblock.Service.Project.Deploy",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "AC4878B9-02A7-4407-91DA-32AEB44DECEA",
            "permission_name": "App.Soundblock.Service.Storage.Simple",
            "permission_memo": "App.Soundblock.Service.Storage.Simple",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "AC6F997E-8E1A-4696-B15E-42B12CBDDF69",
            "permission_name": "App.Soundblock.Service.Storage.Smart",
            "permission_memo": "App.Soundblock.Service.Storage.Smart",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "C53DEA7D-237B-4A85-8914-23FC8B092D6A",
            "permission_name": "App.Soundblock.Service.Report.Payments",
            "permission_memo": "App.Soundblock.Service.Report.Payments",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "22B93005-0BEF-4229-B9C4-2AFEDDDCDDAE",
            "permission_name": "App.Soundblock.Project.Member.Create",
            "permission_memo": "App.Soundblock.Project.Member.Create",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "D44E3BDC-57A6-46FC-9D80-48147ED65BDC",
            "permission_name": "App.Soundblock.Project.Member.Delete",
            "permission_memo": "App.Soundblock.Project.Member.Delete",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "64A9034A-0D54-496E-86F4-AB281FBEEADA",
            "permission_name": "App.Soundblock.Project.Member.Permissions",
            "permission_memo": "App.Soundblock.Project.Member.Permissions",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "1C318E5F-3935-4D46-96B3-2794C711B9CF",
            "permission_name": "App.Soundblock.Project.File.Music.Add",
            "permission_memo": "App.Soundblock.Project.File.Music.Add",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        },
        {
            "permission_uuid": "D2D20063-0845-4814-9168-2418A4138148",
            "permission_name": "App.Soundblock.Project.File.Music.Delete",
            "permission_memo": "App.Soundblock.Project.File.Music.Delete",
            "stamp_created": 1584687080,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687080,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 31,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 4,
            "links": {
                "next": "http:\/\/localhost:8000\/auth\/access\/permissions?page=2"
            },
            "from": 1
        }
    }
}
```

### HTTP Request
`GET core/auth/access/permissions`


<!-- END_796eb599df9d7918a269d1c6d0fd94ae -->

<!-- START_a5fe04290cd4217aa4735d36a4345f33 -->
## core/auth/access/permission
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "user_uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "avatar": {
                "data": {
                    "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                    "stamp_created": 1584687084,
                    "stamp_created_by": {
                        "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584687084,
                    "stamp_updated_by": {
                        "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "DCB38F61-612B-404C-AE5F-868716C06DE4",
                        "auth_uuid": "49B23515-5566-425B-BEB6-5F4004427061",
                        "group_name": "App.Office.Admin",
                        "group_memo": "App.Office.Admin( 2462AFE3-2DA4-4C16-849B-A673AED3EACE )",
                        "stamp_created": 1584687081,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687081,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "908A4B40-2A64-4437-8A7C-77B23412ABB6",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.E85F11C7-3414-42C9-8AC3-AAFBEFF995DF",
                        "group_memo": "App.Soundblock.Service.( E85F11C7-3414-42C9-8AC3-AAFBEFF995DF )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "F4190118-14F2-43EA-AA30-323B7AA0BC74",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.78959C02-0E36-40A3-A8C7-2228141916C2",
                        "group_memo": "App.Soundblock.Service.( 78959C02-0E36-40A3-A8C7-2228141916C2 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "BB5C4C97-2B6C-49B1-82BE-B53C6AC9A810",
            "name_first": "Damon",
            "name_middle": "",
            "name_last": "Evans",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "DCB38F61-612B-404C-AE5F-868716C06DE4",
                        "auth_uuid": "49B23515-5566-425B-BEB6-5F4004427061",
                        "group_name": "App.Office.Admin",
                        "group_memo": "App.Office.Admin( 2462AFE3-2DA4-4C16-849B-A673AED3EACE )",
                        "stamp_created": 1584687081,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687081,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "908A4B40-2A64-4437-8A7C-77B23412ABB6",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.E85F11C7-3414-42C9-8AC3-AAFBEFF995DF",
                        "group_memo": "App.Soundblock.Service.( E85F11C7-3414-42C9-8AC3-AAFBEFF995DF )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    },
                    {
                        "group_uuid": "E4D01B89-3E85-4511-8582-77AB3AAF5E8F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.506EC600-C455-47A3-B5F0-B970C3EAF4BA",
                        "group_memo": "App.Soundblock.Service.( 506EC600-C455-47A3-B5F0-B970C3EAF4BA )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "506D946C-1EFE-4D66-A90A-31D3F23DC00F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.A2DD9319-714D-4FAC-8EAA-29E32DF5F41B",
                        "group_memo": "App.Soundblock.Service.( A2DD9319-714D-4FAC-8EAA-29E32DF5F41B )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    },
                    {
                        "group_uuid": "F4190118-14F2-43EA-AA30-323B7AA0BC74",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.78959C02-0E36-40A3-A8C7-2228141916C2",
                        "group_memo": "App.Soundblock.Service.( 78959C02-0E36-40A3-A8C7-2228141916C2 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "FAD775E0-BC49-4A59-93DF-9F001BE6A71D",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "avatar": {
                "data": {
                    "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                    "stamp_created": 1584687084,
                    "stamp_created_by": {
                        "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584687084,
                    "stamp_updated_by": {
                        "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "DCB38F61-612B-404C-AE5F-868716C06DE4",
                        "auth_uuid": "49B23515-5566-425B-BEB6-5F4004427061",
                        "group_name": "App.Office.Admin",
                        "group_memo": "App.Office.Admin( 2462AFE3-2DA4-4C16-849B-A673AED3EACE )",
                        "stamp_created": 1584687081,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687081,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "E4D01B89-3E85-4511-8582-77AB3AAF5E8F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.506EC600-C455-47A3-B5F0-B970C3EAF4BA",
                        "group_memo": "App.Soundblock.Service.( 506EC600-C455-47A3-B5F0-B970C3EAF4BA )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "506D946C-1EFE-4D66-A90A-31D3F23DC00F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.A2DD9319-714D-4FAC-8EAA-29E32DF5F41B",
                        "group_memo": "App.Soundblock.Service.( A2DD9319-714D-4FAC-8EAA-29E32DF5F41B )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "E3EA4A8D-091E-49A1-B0D9-2EAC3B1E8979",
            "name_first": "jin",
            "name_middle": "",
            "name_last": "tai",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "avatar": {
                "data": {
                    "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                    "stamp_created": 1584687084,
                    "stamp_created_by": {
                        "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584687084,
                    "stamp_updated_by": {
                        "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "DCB38F61-612B-404C-AE5F-868716C06DE4",
                        "auth_uuid": "49B23515-5566-425B-BEB6-5F4004427061",
                        "group_name": "App.Office.Admin",
                        "group_memo": "App.Office.Admin( 2462AFE3-2DA4-4C16-849B-A673AED3EACE )",
                        "stamp_created": 1584687081,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687081,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "F4190118-14F2-43EA-AA30-323B7AA0BC74",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.78959C02-0E36-40A3-A8C7-2228141916C2",
                        "group_memo": "App.Soundblock.Service.( 78959C02-0E36-40A3-A8C7-2228141916C2 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "0F56F69F-5429-401D-AC24-380D7B6A122D",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.87EE6F46-64D6-4066-ABF3-8890635847F1",
                        "group_memo": "App.Soundblock.Service.( 87EE6F46-64D6-4066-ABF3-8890635847F1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    },
                    {
                        "group_uuid": "FC1EC2FD-D0AE-42F5-A04B-F26350011EE3",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.FB569A54-3A63-49D1-8B9D-7D13543728E1",
                        "group_memo": "App.Soundblock.Service.( FB569A54-3A63-49D1-8B9D-7D13543728E1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "4826A64E-0069-4F29-9585-E62C16056B43",
            "name_first": "Lazar",
            "name_middle": "",
            "name_last": "Jankovic",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "DCB38F61-612B-404C-AE5F-868716C06DE4",
                        "auth_uuid": "49B23515-5566-425B-BEB6-5F4004427061",
                        "group_name": "App.Office.Admin",
                        "group_memo": "App.Office.Admin( 2462AFE3-2DA4-4C16-849B-A673AED3EACE )",
                        "stamp_created": 1584687081,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687081,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "908A4B40-2A64-4437-8A7C-77B23412ABB6",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.E85F11C7-3414-42C9-8AC3-AAFBEFF995DF",
                        "group_memo": "App.Soundblock.Service.( E85F11C7-3414-42C9-8AC3-AAFBEFF995DF )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "506D946C-1EFE-4D66-A90A-31D3F23DC00F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.A2DD9319-714D-4FAC-8EAA-29E32DF5F41B",
                        "group_memo": "App.Soundblock.Service.( A2DD9319-714D-4FAC-8EAA-29E32DF5F41B )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "0F56F69F-5429-401D-AC24-380D7B6A122D",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.87EE6F46-64D6-4066-ABF3-8890635847F1",
                        "group_memo": "App.Soundblock.Service.( 87EE6F46-64D6-4066-ABF3-8890635847F1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "FC1EC2FD-D0AE-42F5-A04B-F26350011EE3",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.FB569A54-3A63-49D1-8B9D-7D13543728E1",
                        "group_memo": "App.Soundblock.Service.( FB569A54-3A63-49D1-8B9D-7D13543728E1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "F66A2B92-4187-4086-AD3E-A8A8927A7C42",
            "name_first": "Demo",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "506D946C-1EFE-4D66-A90A-31D3F23DC00F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.A2DD9319-714D-4FAC-8EAA-29E32DF5F41B",
                        "group_memo": "App.Soundblock.Service.( A2DD9319-714D-4FAC-8EAA-29E32DF5F41B )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "0F56F69F-5429-401D-AC24-380D7B6A122D",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.87EE6F46-64D6-4066-ABF3-8890635847F1",
                        "group_memo": "App.Soundblock.Service.( 87EE6F46-64D6-4066-ABF3-8890635847F1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    },
                    {
                        "group_uuid": "FC1EC2FD-D0AE-42F5-A04B-F26350011EE3",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.FB569A54-3A63-49D1-8B9D-7D13543728E1",
                        "group_memo": "App.Soundblock.Service.( FB569A54-3A63-49D1-8B9D-7D13543728E1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "3B721316-851C-487E-9977-D0D91631CCC6",
            "name_first": "Jacky",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "E4D01B89-3E85-4511-8582-77AB3AAF5E8F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.506EC600-C455-47A3-B5F0-B970C3EAF4BA",
                        "group_memo": "App.Soundblock.Service.( 506EC600-C455-47A3-B5F0-B970C3EAF4BA )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    },
                    {
                        "group_uuid": "F4190118-14F2-43EA-AA30-323B7AA0BC74",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.78959C02-0E36-40A3-A8C7-2228141916C2",
                        "group_memo": "App.Soundblock.Service.( 78959C02-0E36-40A3-A8C7-2228141916C2 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 1
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "E781FD6D-3525-4797-BEDD-BCCAB33CF2FA",
            "name_first": "Ace",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "908A4B40-2A64-4437-8A7C-77B23412ABB6",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.E85F11C7-3414-42C9-8AC3-AAFBEFF995DF",
                        "group_memo": "App.Soundblock.Service.( E85F11C7-3414-42C9-8AC3-AAFBEFF995DF )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "B000DC9D-7439-4D07-94F6-241C1A052D3B",
            "name_first": "Polo",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584687081,
            "stamp_created_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584687081,
            "stamp_updated_by": {
                "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "groups_permissions": {
                "data": [
                    {
                        "group_uuid": "E4D01B89-3E85-4511-8582-77AB3AAF5E8F",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.506EC600-C455-47A3-B5F0-B970C3EAF4BA",
                        "group_memo": "App.Soundblock.Service.( 506EC600-C455-47A3-B5F0-B970C3EAF4BA )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    },
                    {
                        "group_uuid": "0F56F69F-5429-401D-AC24-380D7B6A122D",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.87EE6F46-64D6-4066-ABF3-8890635847F1",
                        "group_memo": "App.Soundblock.Service.( 87EE6F46-64D6-4066-ABF3-8890635847F1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    },
                    {
                        "group_uuid": "FC1EC2FD-D0AE-42F5-A04B-F26350011EE3",
                        "auth_uuid": "C345469C-DF8E-4283-813B-06927B58BF0C",
                        "group_name": "App.Soundblock.Service.FB569A54-3A63-49D1-8B9D-7D13543728E1",
                        "group_memo": "App.Soundblock.Service.( FB569A54-3A63-49D1-8B9D-7D13543728E1 )",
                        "stamp_created": 1584687082,
                        "stamp_created_by": {
                            "uuid": "535CA654-85B8-48FE-B4B4-58CE0FCCFA7E",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584687082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "permission": {
                            "data": {
                                "permission_uuid": "47121552-FD65-4780-9D59-1862A018FB91",
                                "permission_value": 0
                            }
                        }
                    }
                ]
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 9,
            "count": 9,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": [],
            "from": 1
        }
    }
}
```

### HTTP Request
`GET core/auth/access/permission`


<!-- END_a5fe04290cd4217aa4735d36a4345f33 -->

<!-- START_2421e420d392f270e3a828321dc1aa23 -->
## core/auth/access/permission
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/auth/access/permission`


<!-- END_2421e420d392f270e3a828321dc1aa23 -->

<!-- START_0141bb4ef6c07513b19085413855fbc3 -->
## core/auth/access/permission/{permission}/groups
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission/ullam/groups"
);

let params = {
    "per_page": "2",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/auth/access/permission/{permission}/groups`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `permission` |  required  | Permission UUID
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `per_page` |  optional  | optional Items per page

<!-- END_0141bb4ef6c07513b19085413855fbc3 -->

<!-- START_2c725586e59209a267ccb4c57e69e939 -->
## core/auth/access/permission/{permission}/users
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission/illum/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/auth/access/permission/{permission}/users`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `permission` |  required  | Permission UUID

<!-- END_2c725586e59209a267ccb4c57e69e939 -->

<!-- START_6692d5f89a76b80d6adab86a29f0b9ed -->
## core/auth/access/permission/{permission}/group
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission/ipsa/group"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "group": "animi",
    "permission_value": false
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH core/auth/access/permission/{permission}/group`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `permission` |  required  | Permission UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `group` | string |  required  | Group UUID
        `permission_value` | boolean |  required  | Permission Value
    
<!-- END_6692d5f89a76b80d6adab86a29f0b9ed -->

<!-- START_33f1592657ea8755fe1fd5894dd431af -->
## core/auth/access/permission/{permission}/user
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission/repellat/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "group": "quaerat",
    "user": "cum",
    "permission_value": false
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH core/auth/access/permission/{permission}/user`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `permission` |  required  | Permission UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `group` | string |  required  | Group UUID.
        `user` | string |  required  | User UUID.
        `permission_value` | boolean |  required  | Permission Value.
    
<!-- END_33f1592657ea8755fe1fd5894dd431af -->

<!-- START_8431c20a9a202b7300bd99c678e181c9 -->
## core/auth/access/permission/{permission}/user
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission/sed/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "group": "vero",
    "user": "velit"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE core/auth/access/permission/{permission}/user`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `permission` |  required  | Permission UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `group` | string |  required  | Group UUID.
        `user` | string |  required  | User UUID.
    
<!-- END_8431c20a9a202b7300bd99c678e181c9 -->

<!-- START_1d0f646502867749697a026efa184cb2 -->
## core/auth/access/permission/{permission}/group
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission/ea/group"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "group": "iste"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE core/auth/access/permission/{permission}/group`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `permission` |  required  | Permission UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `group` | string |  required  | Group UUID.
    
<!-- END_1d0f646502867749697a026efa184cb2 -->

<!-- START_c70f7a0f07c3a13571569af8af8d4c31 -->
## core/auth/access/permission/{permission}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permission/consequatur"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "voluptatem",
    "memo": "at",
    "critical": true
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH core/auth/access/permission/{permission}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `permission` |  required  | Permission UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  optional  | optional Permission Name.
        `memo` | string |  optional  | optional Permission Memo.
        `critical` | boolean |  optional  | optional Is Critical Flag.
    
<!-- END_c70f7a0f07c3a13571569af8af8d4c31 -->

<!-- START_c278702914df354b40441b56cc055424 -->
## core/auth/access/permissions-in-group
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permissions-in-group"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "permission_uuid": "F0DC3F36-D9DA-4829-9437-7CFE8002DC62",
            "permission_name": "App.Soundblock.Service.Storage.Smart",
            "permission_memo": "App.Soundblock.Service.Storage.Smart",
            "stamp_created": 1582659748,
            "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
            "stamp_updated": 1582659748,
            "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
        },
        {
            "permission_uuid": "7E433E62-989C-489A-A006-972FF7F8DC99",
            "permission_name": "App.Soundblock.Service.Report.Payments",
            "permission_memo": "App.Soundblock.Service.Report.Payments",
            "stamp_created": 1582659748,
            "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
            "stamp_updated": 1582659748,
            "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
        }
    ]
}
```

### HTTP Request
`GET core/auth/access/permissions-in-group`


<!-- END_c278702914df354b40441b56cc055424 -->

<!-- START_ea70d16b5401b990720bdeb976002dab -->
## core/auth/access/permissions-user
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/permissions-user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "hic",
    "group": "dolore",
    "permissions": [
        "qui"
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "user_uuid": "DDCA6C8B-BEF6-403E-83AD-FC1C75A91EBB",
        "stamp_created": 1582675326,
        "stamp_created_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636",
        "stamp_updated": 1582675326,
        "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636",
        "permissions_in_group": {
            "data": [
                {
                    "permission_uuid": "B7AB525B-6235-4176-A812-A88491B5961A",
                    "permission_name": "App.Soundblock.Service.Project.Create",
                    "permission_memo": "App.Soundblock.Service.Project.Create",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "B7AB525B-6235-4176-A812-A88491B5961A",
                    "permission_name": "App.Soundblock.Service.Project.Create",
                    "permission_memo": "App.Soundblock.Service.Project.Create",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "3A26A7F2-679E-499C-BCE1-D965510510FB",
                    "permission_name": "App.Soundblock.Service.Project.Deploy",
                    "permission_memo": "App.Soundblock.Service.Project.Deploy",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "3A26A7F2-679E-499C-BCE1-D965510510FB",
                    "permission_name": "App.Soundblock.Service.Project.Deploy",
                    "permission_memo": "App.Soundblock.Service.Project.Deploy",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "C928C3CC-CA01-49CB-8A31-A5A0F6C0D328",
                    "permission_name": "App.Soundblock.Service.Storage.Simple",
                    "permission_memo": "App.Soundblock.Service.Storage.Simple",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "C928C3CC-CA01-49CB-8A31-A5A0F6C0D328",
                    "permission_name": "App.Soundblock.Service.Storage.Simple",
                    "permission_memo": "App.Soundblock.Service.Storage.Simple",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "DFA69801-20C9-46E8-BA0B-DC32A8B8BE5E",
                    "permission_name": "App.Soundblock.Service.Storage.Smart",
                    "permission_memo": "App.Soundblock.Service.Storage.Smart",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "DFA69801-20C9-46E8-BA0B-DC32A8B8BE5E",
                    "permission_name": "App.Soundblock.Service.Storage.Smart",
                    "permission_memo": "App.Soundblock.Service.Storage.Smart",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "ED39F1A6-9B18-4672-BE96-8A4ECBBD8F3C",
                    "permission_name": "App.Soundblock.Service.Report.Payments",
                    "permission_memo": "App.Soundblock.Service.Report.Payments",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "ED39F1A6-9B18-4672-BE96-8A4ECBBD8F3C",
                    "permission_name": "App.Soundblock.Service.Report.Payments",
                    "permission_memo": "App.Soundblock.Service.Report.Payments",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "8B3F2EFE-9E32-4B77-A991-1B0A4AD0AF5F",
                    "permission_name": "App.Soundblock.Project.Member.Create",
                    "permission_memo": "App.Soundblock.Project.Member.Create",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "8B3F2EFE-9E32-4B77-A991-1B0A4AD0AF5F",
                    "permission_name": "App.Soundblock.Project.Member.Create",
                    "permission_memo": "App.Soundblock.Project.Member.Create",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "A36288F3-B30A-4B66-9CCE-4B3D9B936E09",
                    "permission_name": "App.Soundblock.Project.Member.Permissions",
                    "permission_memo": "App.Soundblock.Project.Member.Permissions",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "A36288F3-B30A-4B66-9CCE-4B3D9B936E09",
                    "permission_name": "App.Soundblock.Project.Member.Permissions",
                    "permission_memo": "App.Soundblock.Project.Member.Permissions",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "D08784AE-88B6-4EFE-A728-DBAC45EEEB1A",
                    "permission_name": "App.Soundblock.Project.File.Music.Restore",
                    "permission_memo": "App.Soundblock.Project.File.Music.Restore",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "D08784AE-88B6-4EFE-A728-DBAC45EEEB1A",
                    "permission_name": "App.Soundblock.Project.File.Music.Restore",
                    "permission_memo": "App.Soundblock.Project.File.Music.Restore",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "512DAF63-54DB-4EF5-AF62-A98A32EC3FEA",
                    "permission_name": "App.Soundblock.Project.File.Music.Update",
                    "permission_memo": "App.Soundblock.Project.File.Music.Update",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "512DAF63-54DB-4EF5-AF62-A98A32EC3FEA",
                    "permission_name": "App.Soundblock.Project.File.Music.Update",
                    "permission_memo": "App.Soundblock.Project.File.Music.Update",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "B9ABCC2A-EC4B-4259-B0F7-555339275699",
                    "permission_name": "App.Soundblock.Project.File.Video.Add",
                    "permission_memo": "App.Soundblock.Project.File.Video.Add",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "B9ABCC2A-EC4B-4259-B0F7-555339275699",
                    "permission_name": "App.Soundblock.Project.File.Video.Add",
                    "permission_memo": "App.Soundblock.Project.File.Video.Add",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "6EA7342B-2DF1-432F-953B-D438B774923E",
                    "permission_name": "App.Soundblock.Project.File.Video.Delete",
                    "permission_memo": "App.Soundblock.Project.File.Video.Delete",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "6EA7342B-2DF1-432F-953B-D438B774923E",
                    "permission_name": "App.Soundblock.Project.File.Video.Delete",
                    "permission_memo": "App.Soundblock.Project.File.Video.Delete",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "7F1EF557-D999-4DBB-93B2-606CC5E323EB",
                    "permission_name": "App.Soundblock.Project.File.Video.Update",
                    "permission_memo": "App.Soundblock.Project.File.Video.Update",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "7F1EF557-D999-4DBB-93B2-606CC5E323EB",
                    "permission_name": "App.Soundblock.Project.File.Video.Update",
                    "permission_memo": "App.Soundblock.Project.File.Video.Update",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "F15A64E3-D1C7-4B74-A592-C6FAB5841C3B",
                    "permission_name": "App.Soundblock.Project.File.Video.Download",
                    "permission_memo": "App.Soundblock.Project.File.Video.Download",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "F15A64E3-D1C7-4B74-A592-C6FAB5841C3B",
                    "permission_name": "App.Soundblock.Project.File.Video.Download",
                    "permission_memo": "App.Soundblock.Project.File.Video.Download",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "247E3A5F-ED19-44B7-A568-E90B8FD07559",
                    "permission_name": "App.Soundblock.Project.File.Merch.Delete",
                    "permission_memo": "App.Soundblock.Project.File.Merch.Delete",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "247E3A5F-ED19-44B7-A568-E90B8FD07559",
                    "permission_name": "App.Soundblock.Project.File.Merch.Delete",
                    "permission_memo": "App.Soundblock.Project.File.Merch.Delete",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "C0A1DA3D-6E86-4D4E-8E0C-F52EDCDF205D",
                    "permission_name": "App.Soundblock.Project.File.Merch.Restore",
                    "permission_memo": "App.Soundblock.Project.File.Merch.Restore",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "C0A1DA3D-6E86-4D4E-8E0C-F52EDCDF205D",
                    "permission_name": "App.Soundblock.Project.File.Merch.Restore",
                    "permission_memo": "App.Soundblock.Project.File.Merch.Restore",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "E96291D4-12D3-46F8-B127-6F6672FC5347",
                    "permission_name": "App.Soundblock.Project.File.Merch.Download",
                    "permission_memo": "App.Soundblock.Project.File.Merch.Download",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "E96291D4-12D3-46F8-B127-6F6672FC5347",
                    "permission_name": "App.Soundblock.Project.File.Merch.Download",
                    "permission_memo": "App.Soundblock.Project.File.Merch.Download",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "4D39AE39-AB6A-4EEE-A60C-7F16FA816F51",
                    "permission_name": "App.Soundblock.Project.File.Other.Add",
                    "permission_memo": "App.Soundblock.Project.File.Other.Add",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "4D39AE39-AB6A-4EEE-A60C-7F16FA816F51",
                    "permission_name": "App.Soundblock.Project.File.Other.Add",
                    "permission_memo": "App.Soundblock.Project.File.Other.Add",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "BC11063B-22A5-49EC-82B6-D7A30E6D6C5B",
                    "permission_name": "App.Soundblock.Project.File.Other.Restore",
                    "permission_memo": "App.Soundblock.Project.File.Other.Restore",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "BC11063B-22A5-49EC-82B6-D7A30E6D6C5B",
                    "permission_name": "App.Soundblock.Project.File.Other.Restore",
                    "permission_memo": "App.Soundblock.Project.File.Other.Restore",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "D8E1392C-22D7-4086-A9B8-CE36075DFC9B",
                    "permission_name": "App.Soundblock.Project.File.Other.Update",
                    "permission_memo": "App.Soundblock.Project.File.Other.Update",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "D8E1392C-22D7-4086-A9B8-CE36075DFC9B",
                    "permission_name": "App.Soundblock.Project.File.Other.Update",
                    "permission_memo": "App.Soundblock.Project.File.Other.Update",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "CE075C68-036A-418A-8410-63E236C3AF91",
                    "permission_name": "App.Soundblock.Project.File.Other.Download",
                    "permission_memo": "App.Soundblock.Project.File.Other.Download",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "CE075C68-036A-418A-8410-63E236C3AF91",
                    "permission_name": "App.Soundblock.Project.File.Other.Download",
                    "permission_memo": "App.Soundblock.Project.File.Other.Download",
                    "stamp_created": 1582675325,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582675325,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "6FB73685-3580-4754-B9E3-7B6A59D1E7DE",
                    "permission_name": "permission1",
                    "permission_memo": "34345",
                    "stamp_created": 1582675617,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582679838,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                },
                {
                    "permission_uuid": "210FDD30-09D6-4AC3-825A-DCCBC2314EEE",
                    "permission_name": "permission11",
                    "permission_memo": "343458",
                    "stamp_created": 1582675617,
                    "stamp_created_by": "238950B3-2F95-44F2-B30D-B45F04557FB3",
                    "stamp_updated": 1582679838,
                    "stamp_updated_by": "3698FB72-A5D2-4E24-9C50-48BC2415C636"
                }
            ]
        }
    }
}
```

### HTTP Request
`POST core/auth/access/permissions-user`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | string |  required  | user_uuid
        `group` | string |  required  | group_uuid
        `permissions` | array |  required  | 
        `permissions.*` | string |  required  | 
    
<!-- END_ea70d16b5401b990720bdeb976002dab -->

<!-- START_22048eecbee0f4ef28f5e9ccd6d8345e -->
## core/auth/access/user/{user}/groups
> Example request:

```javascript
const url = new URL(
    "arena.api/core/auth/access/user/modi/groups"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "user_uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
        "name_first": "Samuel",
        "name_middle": "",
        "name_last": "White",
        "stamp_created": 1586289452,
        "stamp_created_by": {
            "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1586289452,
        "stamp_updated_by": {
            "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "groups": {
            "data": [
                {
                    "group_uuid": "B35DDC20-5E57-4256-BD92-CF971417D6E5",
                    "auth_uuid": "CD6E0327-DDD8-41F6-A272-B7FFF13C11A4",
                    "group_name": "App.Office.Admin",
                    "group_memo": "Arena Office: Administrators",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "3AD93B4F-5B6B-46AC-8E01-1258D2F509B5",
                                "permission_name": "App.Office.Admin.Default",
                                "permission_memo": "App.Office.Admin.Default",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "6A9F27A2-2C04-4BBB-83CA-6D433EFE3F85",
                    "auth_uuid": "4FDDF7CE-9145-49CE-9B8D-BE4479565A22",
                    "group_name": "App.Office.Support.Apparel",
                    "group_memo": "Arena Apparel Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "76055E43-548C-42FE-A5B0-7B73F3C47C20",
                    "auth_uuid": "0448B731-E5FE-4CF4-BE6E-8E4D12DF2C97",
                    "group_name": "App.Office.Support.Arena",
                    "group_memo": "Arena: Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "C180614A-F451-4972-A342-C4D1C6B152FA",
                    "auth_uuid": "DCE5EF68-E45E-4BBD-9A8B-02FC7393C8DD",
                    "group_name": "App.Office.Support.Catalog",
                    "group_memo": "Arena Catalog: Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "D0DFBFC5-1A86-470B-9F24-A4A577110F52",
                    "auth_uuid": "19DA5DC5-2269-46FC-A118-48C0397096EE",
                    "group_name": "App.Office.Support.IO",
                    "group_memo": "Arena IO: Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "6603AB93-04A0-4C2E-A406-9D299DCCE137",
                    "auth_uuid": "339B365E-13B9-41E4-BA5F-30CD8787AA22",
                    "group_name": "App.Office.Support.Merchandising",
                    "group_memo": "Arena Merchandising: Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "E853BD07-91AD-41E6-98A1-5CD19DD1E0AB",
                    "auth_uuid": "AABE1DA4-1347-47A3-9595-FEE8D0BE7AA9",
                    "group_name": "App.Office.Support.Music",
                    "group_memo": "Arena Music: Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "8673BAF6-325E-4954-B95F-98BE6AA92C69",
                    "auth_uuid": "CD6E0327-DDD8-41F6-A272-B7FFF13C11A4",
                    "group_name": "App.Office.Support.Office",
                    "group_memo": "Arena Office: Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "8FAC5A2A-1BB6-4DB0-87E0-866BA1473655",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Office.Support.Soundblock",
                    "group_memo": "Arena Soundblock: Support",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": []
                    }
                },
                {
                    "group_uuid": "19925A18-4AE1-4556-898B-73C3505044E0",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Service.2F9579BF-E553-4ED9-BD10-61DD19C416AB",
                    "group_memo": "Soundblock:Service Plan:Saint Cloud",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "AD376A3A-D261-4B7C-910F-0D1E3AC997BF",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Service.A238F936-D7D3-4446-866D-F6ACC369C9A8",
                    "group_memo": "Soundblock:Service Plan:Gigaton",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "6525193B-296E-4063-AFF6-DD5C1A57647E",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Project.ED6943FC-CB31-4B4E-8BA4-2F4E4F52BF40",
                    "group_memo": "App.Soundblock.Project.( ED6943FC-CB31-4B4E-8BA4-2F4E4F52BF40 )",
                    "stamp_created": 1586289452,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289452,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "35CBF08D-B267-4D55-8F40-C3762669523F",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Project.3679FB5C-0E51-4024-BBC3-DE6B4CE0D17C",
                    "group_memo": "App.Soundblock.Project.( 3679FB5C-0E51-4024-BBC3-DE6B4CE0D17C )",
                    "stamp_created": 1586289453,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289453,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "CE64EA8B-95A4-4283-BE47-B552A5ECF78B",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Project.09AD1481-3BDC-4B7E-A564-22E202D991CA",
                    "group_memo": "App.Soundblock.Project.( 09AD1481-3BDC-4B7E-A564-22E202D991CA )",
                    "stamp_created": 1586289453,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289453,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "14BB753E-C518-4284-B917-BA3D6BA0BA63",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Project.D1BD2465-0A27-4E3A-B8CF-B6E8A63554AC",
                    "group_memo": "App.Soundblock.Project.( D1BD2465-0A27-4E3A-B8CF-B6E8A63554AC )",
                    "stamp_created": 1586289453,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289453,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "670AE302-4291-40D7-9D89-1C435CD0B378",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Project.480A27E9-0A0D-43DC-A6CD-89BF80AD652B",
                    "group_memo": "App.Soundblock.Project.( 480A27E9-0A0D-43DC-A6CD-89BF80AD652B )",
                    "stamp_created": 1586289453,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289453,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                },
                {
                    "group_uuid": "63492A2C-DE7F-4205-B629-3B8B800F6F35",
                    "auth_uuid": "B3FF0CD6-37B8-41D7-B975-A35A52236E97",
                    "group_name": "App.Soundblock.Project.F98B086A-5B30-48A6-BAC0-508501115CC6",
                    "group_memo": "App.Soundblock.Project.( F98B086A-5B30-48A6-BAC0-508501115CC6 )",
                    "stamp_created": 1586289454,
                    "stamp_created_by": {
                        "uuid": "AA1BC47F-3A85-4145-861F-CCBD12D210AF",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1586289454,
                    "stamp_updated_by": {
                        "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                    },
                    "permissions": {
                        "data": [
                            {
                                "permission_uuid": "C31E20A9-BBF7-4657-92C0-060BCCC56CC8",
                                "permission_name": "qqq2",
                                "permission_memo": "qqq",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586349922,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "936E11B8-4DAD-408D-845B-6B11E76341CE",
                                "permission_name": "App.Soundblock.Service.Project.Deploy",
                                "permission_memo": "App.Soundblock.Service.Project.Deploy",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "417C4449-96B0-46A2-9CAD-FD6BCD4370FA",
                                "permission_name": "App.Soundblock.Service.Report.Payments",
                                "permission_memo": "App.Soundblock.Service.Report.Payments",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "25CD2DC9-BF04-433F-AF7D-A29BDC9C83E8",
                                "permission_name": "App.Soundblock.Project.Member.Create",
                                "permission_memo": "App.Soundblock.Project.Member.Create",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            },
                            {
                                "permission_uuid": "5E394F9B-B6CA-4628-AAEA-07B3CEF72B22",
                                "permission_name": "App.Soundblock.Project.Member.Delete",
                                "permission_memo": "App.Soundblock.Project.Member.Delete",
                                "stamp_created": 1586289451,
                                "stamp_created_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "stamp_updated": 1586289451,
                                "stamp_updated_by": {
                                    "uuid": "529374AD-C19A-4D70-BDC1-38491F6C84DE"
                                },
                                "permission_value": 1
                            }
                        ]
                    }
                }
            ]
        }
    }
}
```

### HTTP Request
`GET core/auth/access/user/{user}/groups`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | User UUID

<!-- END_22048eecbee0f4ef28f5e9ccd6d8345e -->

<!-- START_32e9af17ab99f0adfdfdf604e7923020 -->
## office/groups/autocomplete
> Example request:

```javascript
const url = new URL(
    "arena.api/office/groups/autocomplete"
);

let params = {
    "name": "in",
    "memo": "ex",
    "select_fields": "non",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/groups/autocomplete`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `name` |  optional  | Group Name.
    `memo` |  optional  | Group Memo.
    `select_fields` |  optional  | The list of fields that will selected. Fields: name - group_name, memo - group_memo, is_critical - flag_critical, group - group_uuid, auth - auth_uuid. E.g select_fields=name,memo

<!-- END_32e9af17ab99f0adfdfdf604e7923020 -->

<!-- START_684b255e8a35e5524fc47c8bcff30b95 -->
## office/services/groups
> Example request:

```javascript
const url = new URL(
    "arena.api/office/services/groups"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/services/groups`


<!-- END_684b255e8a35e5524fc47c8bcff30b95 -->

#Collection


APIs for Collection
<!-- START_a4288c47285b32dd12fe4b1ee0026e06 -->
## office/soundblock/project/collection
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/collection"
);

let params = {
    "collection": "cum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "Music": [
            {
                "file_uuid": "B02E829D-501A-4BEF-9C23-81D44844859E",
                "file_name": "Stan.mp3",
                "file_path": "\/Music",
                "file_category": "music",
                "file_sortby": "\/Music\/Stan.mp3",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "E8C0570F-50EA-4F55-8792-6CCA96D74C86",
                "file_name": "Marshal Mathers.mp3",
                "file_path": "\/Music",
                "file_category": "music",
                "file_sortby": "\/Music\/Marshal Mathers.mp3",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "64EFC10E-F8D8-4537-BE49-F8C8CCF588CE",
                "file_name": "I'm Back.mp3",
                "file_path": "\/Music",
                "file_category": "music",
                "file_sortby": "\/Music\/I'm Back.mp3",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "7033974B-4DE0-4610-9E95-B87B80611D66",
                "file_name": "Old Town Road.mp3",
                "file_path": "\/Music",
                "file_category": "music",
                "file_sortby": "\/Music\/Old Town Road.mp3",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "BA84CB7C-1497-406D-8E31-583A11A85AF8",
                "file_name": "Don't Start Now.mp3",
                "file_path": "\/Music",
                "file_category": "music",
                "file_sortby": "\/Music\/Don't Start Now.mp3",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "FD4BB289-17F2-4CBA-B773-A0A1B73FF96C",
                "file_name": "Lose you to love me.mp3",
                "file_path": "\/Music",
                "file_category": "music",
                "file_sortby": "\/Music\/Lose you to love me.mp3",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            }
        ],
        "Video": [
            {
                "file_uuid": "14A3EFDC-DBA5-494C-A84D-C8FDAA0F90BA",
                "file_name": "back.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/back.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "F093FC52-C6F3-4327-802A-31F2CA4B406E",
                "file_name": "video1.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/back.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "037305EA-A1B9-4370-A205-E9D29A79C0BE",
                "file_name": "video2.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/video2.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "317D21C1-9C7D-4FD3-847A-038DD54B6D4C",
                "file_name": "video2.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/marshal.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "BDBF1A87-73C2-4874-90C4-238396846EE6",
                "file_name": "video3.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/video3.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "81195143-2894-4941-B6A6-28018F011E3F",
                "file_name": "Old Town Road.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/Old town road.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "C8DBCFF8-94C1-4402-B0C0-402911E2A57D",
                "file_name": "Don't Start Now.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/Old town road.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "0A9A54F1-CAAA-4629-A809-AD546523F540",
                "file_name": "Lose you to love me.mp4",
                "file_path": "\/Video",
                "file_category": "video",
                "file_sortby": "\/Video\/Lose you to love me.mp4",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            }
        ],
        "Merch": [
            {
                "file_uuid": "3529217C-2F63-4355-B8D8-4D3C9FFFEAFA",
                "file_name": "Panic.ai",
                "file_path": "\/Merch",
                "file_category": "merch",
                "file_sortby": "\/Merch\/Panic.ai",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "573F579F-8C40-4269-B3AC-E46776B2C7F2",
                "file_name": "22.psd",
                "file_path": "\/Merch",
                "file_category": "merch",
                "file_sortby": "\/Merch\/22.psd",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "C0D5EC06-8497-4760-B0E9-366505861A7C",
                "file_name": "Me!.psd",
                "file_path": "\/Merch",
                "file_category": "merch",
                "file_sortby": "\/Merch\/Me!.psd",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "C0B223C2-3EA6-4D73-8996-F47D012CF33D",
                "file_name": "Lose you.ai",
                "file_path": "\/Merch",
                "file_category": "merch",
                "file_sortby": "\/Merch\/Lose you.ai",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "9724CEDA-A981-42FD-AEE2-5F85AB902802",
                "file_name": "Old Town Road.ai",
                "file_path": "\/Merch",
                "file_category": "merch",
                "file_sortby": "\/Merch\/Old Town Road.ai",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "directory_uuid": "B04FFE04-210D-4E85-A823-0671D577CFB6",
                "directory_name": "Panic",
                "directory_path": "\/Merch",
                "directory_sortby": "\/Merch\/Panic",
                "kind": "directory",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161,
                "child": [
                    {
                        "file_uuid": "F9CE3237-D89D-4732-BA1A-82E80CE65457",
                        "file_name": "Panic.ai",
                        "file_path": "\/Merch\/Panic",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Panic\/Panic.ai",
                        "kind": "file",
                        "stamp_created": 1584499161,
                        "stamp_updated": 1584499161
                    },
                    {
                        "file_uuid": "2261D973-C2FD-40E9-90C9-FBE48B43148D",
                        "file_name": "22.psd",
                        "file_path": "\/Merch\/Panic",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Panic\/22.psd",
                        "kind": "file",
                        "stamp_created": 1584499161,
                        "stamp_updated": 1584499161
                    },
                    {
                        "directory_uuid": "89A09324-349D-4F1B-9E79-72353317D6E3",
                        "directory_name": "Taylor",
                        "directory_path": "\/Merch\/Panic",
                        "directory_sortby": "\/Merch\/Panic\/Same",
                        "kind": "directory",
                        "stamp_created": 1584499161,
                        "stamp_updated": 1584499161,
                        "child": [
                            {
                                "file_uuid": "C77F013D-43A5-4BC7-AAFD-95B1D1B9B9B3",
                                "file_name": "Me!.psd",
                                "file_path": "\/Merch\/Panic\/Same",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Panic\/Same\/Me!.psd",
                                "kind": "file",
                                "stamp_created": 1584499161,
                                "stamp_updated": 1584499161
                            },
                            {
                                "file_uuid": "51DF3D7C-57E0-4026-8849-2C96886EE42D",
                                "file_name": "Style.psd",
                                "file_path": "\/Merch\/Panic\/Same",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Panic\/Same\/Style.psd",
                                "kind": "file",
                                "stamp_created": 1584499161,
                                "stamp_updated": 1584499161
                            },
                            {
                                "file_uuid": "E6DD7D8D-87FA-454A-AA09-F211B3EA2B28",
                                "file_name": "Shake_it_off.ai",
                                "file_path": "\/Merch\/Panic\/Same",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Panic\/Same\/Shake_it_off.ai",
                                "kind": "file",
                                "stamp_created": 1584499161,
                                "stamp_updated": 1584499161
                            }
                        ]
                    }
                ]
            }
        ],
        "Other": [
            {
                "file_uuid": "C1355E5F-48BD-4151-9B7E-69847DAE873A",
                "file_name": "file-1.doc",
                "file_path": "\/Other",
                "file_category": "other",
                "file_sortby": "\/Other\/file-1.doc",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "42045F4C-6E3F-4DE1-A1D6-907E3778287C",
                "file_name": "Files-2.doc",
                "file_path": "\/Other",
                "file_category": "other",
                "file_sortby": "\/Other\/Files-2.doc",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "4CB29A14-1938-4FF6-A687-6B67F08684D6",
                "file_name": "files-4.docx",
                "file_path": "\/Other",
                "file_category": "other",
                "file_sortby": "\/Other\/files-4.docx",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            },
            {
                "file_uuid": "3F5008DF-3A99-47B9-8F5B-23DA5C266327",
                "file_name": "description.doc",
                "file_path": "\/Other",
                "file_category": "other",
                "file_sortby": "\/Other\/description.doc",
                "kind": "file",
                "stamp_created": 1584499161,
                "stamp_updated": 1584499161
            }
        ]
    }
}
```

### HTTP Request
`GET office/soundblock/project/collection`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `collection` |  optional  | string required

<!-- END_a4288c47285b32dd12fe4b1ee0026e06 -->

<!-- START_07428172f61b821ac20d4d34381f047d -->
## office/soundblock/project/collection/download
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/collection/download"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "collection": "quisquam",
    "files": [
        {
            "file_uuid": "totam"
        }
    ]
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/soundblock/project/collection/download`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `collection` | uuid |  required  | Collection UUID
        `files` | array |  required  | The array of files
        `files.*.file_uuid` | File |  optional  | UUID
    
<!-- END_07428172f61b821ac20d4d34381f047d -->

<!-- START_862ebda210d53a3c7e1e8c3b8f771822 -->
## soundblock/project/{project}/collections
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/1/collections"
);

let params = {
    "project": "dignissimos",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "collection_uuid": "C7B547E1-008D-4A33-A0C0-6C0DBD544A25",
            "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
            "collection_comment": "Calista Runolfsson",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "history": {
                "data": {
                    "history_uuid": "723F3F79-4256-4698-A9B5-334399667287",
                    "history_category": "Multiple",
                    "history_size": 5783021,
                    "file_action": "Created",
                    "history_comment": "Music( CaapmTqpbcZGz5NB )",
                    "stamp_created": 1584179856,
                    "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                }
            },
            "fileshistory": {
                "data": [
                    {
                        "file_id": 10,
                        "file_uuid": "B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5",
                        "file_name": "Panic.ai",
                        "file_path": "\/Merch\/Panic",
                        "file_title": "Panic",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Panic\/Panic.ai",
                        "file_size": 224497,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5 )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 1,
                        "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                        "file_name": "Stan.mp3",
                        "file_path": "\/Music",
                        "file_title": "Stan",
                        "file_category": "music",
                        "file_sortby": "\/Music\/Stan.mp3",
                        "file_size": 294084,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 683552A6-6315-4EA6-85C2-745A6511C22B )",
                        "file_track": 2,
                        "file_duration": 263,
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 15,
                        "file_uuid": "87D18889-B923-4F6F-9456-BCC7760052C1",
                        "file_name": "Style.psd",
                        "file_path": "\/Merch\/Taylor",
                        "file_title": "Style",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Taylor\/Style.psd",
                        "file_size": 42923,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 87D18889-B923-4F6F-9456-BCC7760052C1 )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "87D18889-B923-4F6F-9456-BCC7760052C1",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 6,
                        "file_uuid": "6F782D8B-F0F3-41CC-BD12-C1785AC3277C",
                        "file_name": "video2.mp4",
                        "file_path": "\/Video",
                        "file_title": "video2",
                        "file_category": "video",
                        "file_sortby": "\/Video\/video2.mp4",
                        "file_size": 296578,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 6F782D8B-F0F3-41CC-BD12-C1785AC3277C )",
                        "track_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                        "track": "Stan",
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "6F782D8B-F0F3-41CC-BD12-C1785AC3277C",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 20,
                        "file_uuid": "87F9A531-FC9F-40D0-B9E1-BE2577865ABD",
                        "file_name": "Files-2.doc",
                        "file_path": "\/Other\/Files",
                        "file_title": "Files-2",
                        "file_category": "other",
                        "file_sortby": "\/Other\/Files\/Files-2.doc",
                        "file_size": 452621,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 87F9A531-FC9F-40D0-B9E1-BE2577865ABD )",
                        "file_history": [
                            {
                                "file_uuid": "87F9A531-FC9F-40D0-B9E1-BE2577865ABD",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 11,
                        "file_uuid": "6A7F364A-BA16-4DDD-AC93-612F57E73C98",
                        "file_name": "22.psd",
                        "file_path": "\/Merch",
                        "file_title": "22",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/22.psd",
                        "file_size": 424907,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 6A7F364A-BA16-4DDD-AC93-612F57E73C98 )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "6A7F364A-BA16-4DDD-AC93-612F57E73C98",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 2,
                        "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                        "file_name": "Marshal Mathers.mp3",
                        "file_path": "\/Music",
                        "file_title": "Marshal",
                        "file_category": "music",
                        "file_sortby": "\/Music\/Marshal Mathers.mp3",
                        "file_size": 270163,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 992540C5-F9CA-420D-9327-7058232DF2B2 )",
                        "file_track": 3,
                        "file_duration": 252,
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 16,
                        "file_uuid": "6267298C-BC14-456E-B3B5-E30407EF4A80",
                        "file_name": "Shake_it_off.ai",
                        "file_path": "\/Merch\/Taylor",
                        "file_title": "Shake_it_off",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Taylor\/Shake_it_off.ai",
                        "file_size": 415981,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 6267298C-BC14-456E-B3B5-E30407EF4A80 )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "6267298C-BC14-456E-B3B5-E30407EF4A80",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 7,
                        "file_uuid": "C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40",
                        "file_name": "video2.mp4",
                        "file_path": "\/Video",
                        "file_title": "video2",
                        "file_category": "video",
                        "file_sortby": "\/Video\/marshal.mp4",
                        "file_size": 195797,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40 )",
                        "track_uuid": "350FE70C-92A9-48EC-8E0C-C21EDFC326C3",
                        "track": "Don't Start Now",
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 21,
                        "file_uuid": "C406184B-3FFA-4DFD-BEEE-EDADED0F075B",
                        "file_name": "files-4.docx",
                        "file_path": "\/Other",
                        "file_title": "files-4",
                        "file_category": "other",
                        "file_sortby": "\/Other\/files-4.docx",
                        "file_size": 213584,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( C406184B-3FFA-4DFD-BEEE-EDADED0F075B )",
                        "file_history": [
                            {
                                "file_uuid": "C406184B-3FFA-4DFD-BEEE-EDADED0F075B",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 12,
                        "file_uuid": "703A32B8-E17B-47C3-8669-ED4362F68434",
                        "file_name": "22.psd",
                        "file_path": "\/Merch\/Panic",
                        "file_title": null,
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Panic\/22.psd",
                        "file_size": 230392,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 703A32B8-E17B-47C3-8669-ED4362F68434 )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "703A32B8-E17B-47C3-8669-ED4362F68434",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 3,
                        "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                        "file_name": "I'm Back.mp3",
                        "file_path": "\/Music",
                        "file_title": "I'm Back",
                        "file_category": "music",
                        "file_sortby": "\/Music\/I'm Back.mp3",
                        "file_size": 41774,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E )",
                        "file_track": 1,
                        "file_duration": 297,
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 17,
                        "file_uuid": "C70F71CD-9091-40B6-A524-1EE9D93E46F5",
                        "file_name": "file-1.doc",
                        "file_path": "\/Other",
                        "file_title": "file-1",
                        "file_category": "other",
                        "file_sortby": "\/Other\/file-1.doc",
                        "file_size": 277047,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( C70F71CD-9091-40B6-A524-1EE9D93E46F5 )",
                        "file_history": [
                            {
                                "file_uuid": "C70F71CD-9091-40B6-A524-1EE9D93E46F5",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 8,
                        "file_uuid": "F10B49EE-D440-4129-A064-2297BE3EEDF4",
                        "file_name": "video3.mp4",
                        "file_path": "\/Video",
                        "file_title": "video3",
                        "file_category": "video",
                        "file_sortby": "\/Video\/video3.mp4",
                        "file_size": 143251,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( F10B49EE-D440-4129-A064-2297BE3EEDF4 )",
                        "track_uuid": "57C1E8AE-8E99-45BB-A84D-F8D61F968D3E",
                        "track": "Lose You To Love Me",
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "F10B49EE-D440-4129-A064-2297BE3EEDF4",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 13,
                        "file_uuid": "3DD9FB96-1711-467A-ABD5-75A2287EECEC",
                        "file_name": "Me!.psd",
                        "file_path": "\/Merch",
                        "file_title": "merch",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Me!.psd",
                        "file_size": 495901,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 3DD9FB96-1711-467A-ABD5-75A2287EECEC )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "3DD9FB96-1711-467A-ABD5-75A2287EECEC",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 4,
                        "file_uuid": "3C08F084-DD6C-45D4-8058-56194196602A",
                        "file_name": "back.mp4",
                        "file_path": "\/Video",
                        "file_title": "back",
                        "file_category": "video",
                        "file_sortby": "\/Video\/back.mp4",
                        "file_size": 107950,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 3C08F084-DD6C-45D4-8058-56194196602A )",
                        "track_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                        "track": "Marshal",
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "3C08F084-DD6C-45D4-8058-56194196602A",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 18,
                        "file_uuid": "0D21E453-0ED9-4E18-8BBE-A454E97389C5",
                        "file_name": "file-1.doc",
                        "file_path": "\/Other\/Files",
                        "file_title": "file-1",
                        "file_category": "other",
                        "file_sortby": "\/Other\/Files\/file-1.doc",
                        "file_size": 257269,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 0D21E453-0ED9-4E18-8BBE-A454E97389C5 )",
                        "file_history": [
                            {
                                "file_uuid": "0D21E453-0ED9-4E18-8BBE-A454E97389C5",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 9,
                        "file_uuid": "4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A",
                        "file_name": "Panic.ai",
                        "file_path": "\/Merch",
                        "file_title": "Panic",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Panic.ai",
                        "file_size": 447387,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 14,
                        "file_uuid": "60FCCF9F-DA47-4473-940F-41D1B7844159",
                        "file_name": "Me!.psd",
                        "file_path": "\/Merch\/Taylor",
                        "file_title": "merch",
                        "file_category": "merch",
                        "file_sortby": "\/Merch\/Taylor\/Me!.psd",
                        "file_size": 318598,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 60FCCF9F-DA47-4473-940F-41D1B7844159 )",
                        "file_sku": "4225-776-3234",
                        "file_history": [
                            {
                                "file_uuid": "60FCCF9F-DA47-4473-940F-41D1B7844159",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 5,
                        "file_uuid": "D81267FD-B51E-489E-B0D2-19E6F09CBBA4",
                        "file_name": "video1.mp4",
                        "file_path": "\/Video",
                        "file_title": "video1",
                        "file_category": "video",
                        "file_sortby": "\/Video\/back.mp4",
                        "file_size": 228962,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( D81267FD-B51E-489E-B0D2-19E6F09CBBA4 )",
                        "track_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                        "track": "Everyone Like",
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "D81267FD-B51E-489E-B0D2-19E6F09CBBA4",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 19,
                        "file_uuid": "45283D97-3278-48DF-AA70-7AFAD9E77A0D",
                        "file_name": "Files-2.doc",
                        "file_path": "\/Other",
                        "file_title": "Files-2",
                        "file_category": "other",
                        "file_sortby": "\/Other\/Files-2.doc",
                        "file_size": 403355,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File( 45283D97-3278-48DF-AA70-7AFAD9E77A0D )",
                        "file_history": [
                            {
                                "file_uuid": "45283D97-3278-48DF-AA70-7AFAD9E77A0D",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                }
                            }
                        ]
                    }
                ]
            }
        },
        {
            "collection_uuid": "1F9AE105-D7FD-40B1-BC1F-1C978E8D4B96",
            "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
            "collection_comment": "**yurii",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "history": {
                "data": {
                    "history_uuid": "25DD8DFE-2D2B-4DD8-9679-553B94903DF2",
                    "history_category": "Music",
                    "history_size": 681050,
                    "file_action": "Created",
                    "history_comment": "Music( vtQ4RpEYLoMcNS44 )",
                    "stamp_created": 1584179856,
                    "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                }
            },
            "fileshistory": {
                "data": [
                    {
                        "file_id": 31,
                        "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                        "file_name": "special.mp3",
                        "file_path": "\/Music",
                        "file_title": "Everyone Like",
                        "file_category": "music",
                        "file_sortby": "\/Music\/special.mp3",
                        "file_size": 345095,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File ( 50F762AB-B76E-4743-8EB9-A13CB47FA33D ) Created",
                        "file_track": 2,
                        "file_duration": 252,
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 32,
                        "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                        "file_name": "special-1.mp3",
                        "file_path": "\/Music",
                        "file_title": "Everyone Like",
                        "file_category": "music",
                        "file_sortby": "\/Music\/sepcial-1.mp3",
                        "file_size": 335955,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File ( 5A5774DA-8346-4ED8-A5F7-0C3C20C12643 ) Created",
                        "file_track": 3,
                        "file_duration": 277,
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "file_action": "Deleted",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            },
                            {
                                "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            }
                        ]
                    }
                ]
            }
        },
        {
            "collection_uuid": "90F2F1A4-F296-43AC-ADBD-F8A4BF495C99",
            "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
            "collection_comment": "**yurii",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "history": {
                "data": {
                    "history_uuid": "2A0E23E7-A132-459F-AF63-1298B420FD0E",
                    "history_category": "Video",
                    "history_size": 335955,
                    "file_action": "Deleted",
                    "history_comment": "Video( WabHQDmXO96YwOsJ )",
                    "stamp_created": 1584179856,
                    "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                }
            },
            "fileshistory": {
                "data": [
                    {
                        "file_id": 32,
                        "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                        "file_name": "special-1.mp3",
                        "file_path": "\/Music",
                        "file_title": "Everyone Like",
                        "file_category": "music",
                        "file_sortby": "\/Music\/sepcial-1.mp3",
                        "file_size": 335955,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Deleted",
                        "file_memo": "File ( 5A5774DA-8346-4ED8-A5F7-0C3C20C12643 ) Deleted",
                        "file_track": 3,
                        "file_duration": 277,
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "file_action": "Deleted",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            },
                            {
                                "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            }
                        ]
                    }
                ]
            }
        },
        {
            "collection_uuid": "329AC445-0317-4A19-856C-40624BCD80A1",
            "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
            "collection_comment": "**yurii",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "history": {
                "data": {
                    "history_uuid": "844E1DF3-67D3-4A66-B295-1C6D1D58D945",
                    "history_category": "Multiple",
                    "history_size": 1325300,
                    "file_action": "Created",
                    "history_comment": "Multiple( ZSepHTqw9HsrXx31 )",
                    "stamp_created": 1584179856,
                    "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                }
            },
            "fileshistory": {
                "data": [
                    {
                        "file_id": 33,
                        "file_uuid": "1D869E35-C4BE-482D-9B7F-B4968ABF4750",
                        "file_name": "special-video.mp4",
                        "file_path": "\/Video",
                        "file_title": "Everyone Like this",
                        "file_category": "video",
                        "file_sortby": "\/Video\/special-video.mp4",
                        "file_size": 354531,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File ( 1D869E35-C4BE-482D-9B7F-B4968ABF4750 ) Created",
                        "track_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                        "track": "Stan",
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "1D869E35-C4BE-482D-9B7F-B4968ABF4750",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            }
                        ]
                    },
                    {
                        "file_id": 34,
                        "file_uuid": "EFAC68DF-6468-4A28-A8B4-0EE2E03D0294",
                        "file_name": "special-image.ai",
                        "file_path": "\/Video",
                        "file_title": "Everyone Like this",
                        "file_category": "video",
                        "file_sortby": "\/Video\/special-video-1.mp4",
                        "file_size": 280579,
                        "stamp_created": 1584179856,
                        "stamp_created_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584179856,
                        "stamp_updated_by": {
                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "file_action": "Created",
                        "file_memo": "File ( EFAC68DF-6468-4A28-A8B4-0EE2E03D0294 ) Created",
                        "track_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                        "track": "Stan",
                        "file_isrc": "NOX001212345",
                        "file_history": [
                            {
                                "file_uuid": "EFAC68DF-6468-4A28-A8B4-0EE2E03D0294",
                                "file_action": "Created",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                    "name_first": "Yurii",
                                    "name_middle": "",
                                    "name_last": "Kosiak"
                                }
                            }
                        ]
                    }
                ]
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 4,
            "count": 4,
            "per_page": 5,
            "current_page": 1,
            "total_pages": 1,
            "links": [],
            "from": 1
        }
    }
}
```

### HTTP Request
`GET soundblock/project/{project}/collections`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `project` |  optional  | uuid required Project UUID

<!-- END_862ebda210d53a3c7e1e8c3b8f771822 -->

<!-- START_c78c0bdd94d1fe4c99b9d2846e4d3203 -->
## soundblock/project/collection/{collection}/tracks
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/1/tracks"
);

let params = {
    "collection": "rerum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "329AC445-0317-4A19-856C-40624BCD80A1",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "**yurii",
        "stamp_created": 1584179856,
        "stamp_created_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1584179856,
        "stamp_updated_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "musics": {
            "data": [
                {
                    "file_track": 1,
                    "file_duration": 297,
                    "file_isrc": "NOX001212345",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_id": 3,
                    "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                    "file_name": "I'm Back.mp3",
                    "file_path": "\/Music",
                    "file_title": "I'm Back",
                    "file_category": "music",
                    "file_sortby": "\/Music\/I'm Back.mp3",
                    "file_size": 41774
                },
                {
                    "file_track": 2,
                    "file_duration": 252,
                    "file_isrc": "NOX001212345",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_id": 31,
                    "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                    "file_name": "special.mp3",
                    "file_path": "\/Music",
                    "file_title": "Everyone Like",
                    "file_category": "music",
                    "file_sortby": "\/Music\/special.mp3",
                    "file_size": 345095
                },
                {
                    "file_track": 2,
                    "file_duration": 263,
                    "file_isrc": "NOX001212345",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_id": 1,
                    "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                    "file_name": "Stan.mp3",
                    "file_path": "\/Music",
                    "file_title": "Stan",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Stan.mp3",
                    "file_size": 294084
                },
                {
                    "file_track": 3,
                    "file_duration": 252,
                    "file_isrc": "NOX001212345",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_id": 2,
                    "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                    "file_name": "Marshal Mathers.mp3",
                    "file_path": "\/Music",
                    "file_title": "Marshal",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Marshal Mathers.mp3",
                    "file_size": 270163
                }
            ]
        }
    }
}
```

### HTTP Request
`GET soundblock/project/collection/{collection}/tracks`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `collection` |  optional  | uuid required Collection UUID

<!-- END_c78c0bdd94d1fe4c99b9d2846e4d3203 -->

<!-- START_fdc14dd6c26c36a27c290f0c837ced49 -->
## soundblock/project/collection/{collection}/history
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/1/history"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/collection/{collection}/history`


<!-- END_fdc14dd6c26c36a27c290f0c837ced49 -->

<!-- START_1717450370184504ed20da5882964174 -->
## soundblock/project/collection/file/{file}/history
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/file/1/history"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/collection/file/{file}/history`


<!-- END_1717450370184504ed20da5882964174 -->

<!-- START_3bb0755f751ad107a6e44e6d2ee3f04f -->
## soundblock/project/collection/{collection}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/1"
);

let params = {
    "collection": "ut",
    "file_path": "veniam",
    "file_category": "qui",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "collection": "molestiae",
    "file_path": "nulla"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "C7B547E1-008D-4A33-A0C0-6C0DBD544A25",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "Calista Runolfsson",
        "stamp_created": 1584179856,
        "stamp_created_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1584179856,
        "stamp_updated_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "files": {
            "data": [
                {
                    "file_id": 23,
                    "file_uuid": "350FE70C-92A9-48EC-8E0C-C21EDFC326C3",
                    "file_name": "Don't Start Now.mp3",
                    "file_path": "\/Music",
                    "file_title": "Don't Start Now",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Don't Start Now.mp3",
                    "file_size": 312204,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_track": 3,
                    "file_duration": 278,
                    "file_isrc": "NOX001212345",
                    "revertable": false,
                    "restorable": true,
                    "file_history": [
                        {
                            "file_uuid": "350FE70C-92A9-48EC-8E0C-C21EDFC326C3",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 3,
                    "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                    "file_name": "I'm Back.mp3",
                    "file_path": "\/Music",
                    "file_title": "I'm Back",
                    "file_category": "music",
                    "file_sortby": "\/Music\/I'm Back.mp3",
                    "file_size": 41774,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_track": 1,
                    "file_duration": 297,
                    "file_isrc": "NOX001212345",
                    "revertable": false,
                    "restorable": false,
                    "file_history": [
                        {
                            "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 24,
                    "file_uuid": "57C1E8AE-8E99-45BB-A84D-F8D61F968D3E",
                    "file_name": "Lose you to love me.mp3",
                    "file_path": "\/Music",
                    "file_title": "Lose You To Love Me",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Lose you to love me.mp3",
                    "file_size": 126504,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_track": 1,
                    "file_duration": 238,
                    "file_isrc": "NOX001212345",
                    "revertable": false,
                    "restorable": true,
                    "file_history": [
                        {
                            "file_uuid": "57C1E8AE-8E99-45BB-A84D-F8D61F968D3E",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 2,
                    "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                    "file_name": "Marshal Mathers.mp3",
                    "file_path": "\/Music",
                    "file_title": "Marshal",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Marshal Mathers.mp3",
                    "file_size": 270163,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_track": 3,
                    "file_duration": 252,
                    "file_isrc": "NOX001212345",
                    "revertable": false,
                    "restorable": false,
                    "file_history": [
                        {
                            "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 22,
                    "file_uuid": "A280ED6C-76DA-4929-BD79-03C757A7EA9A",
                    "file_name": "Old Town Road.mp3",
                    "file_path": "\/Music",
                    "file_title": "Old Town Road",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Old Town Road.mp3",
                    "file_size": 320068,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_track": 2,
                    "file_duration": 275,
                    "file_isrc": "NOX001212345",
                    "revertable": false,
                    "restorable": true,
                    "file_history": [
                        {
                            "file_uuid": "A280ED6C-76DA-4929-BD79-03C757A7EA9A",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 1,
                    "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                    "file_name": "Stan.mp3",
                    "file_path": "\/Music",
                    "file_title": "Stan",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Stan.mp3",
                    "file_size": 294084,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_track": 2,
                    "file_duration": 263,
                    "file_isrc": "NOX001212345",
                    "revertable": false,
                    "restorable": false,
                    "file_history": [
                        {
                            "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                }
            ]
        },
        "directories": {
            "data": []
        },
        "history": {
            "data": {
                "history_uuid": "723F3F79-4256-4698-A9B5-334399667287",
                "history_category": "Multiple",
                "history_size": 5783021,
                "file_action": "Created",
                "history_comment": "Music( CaapmTqpbcZGz5NB )",
                "stamp_created": 1584179856,
                "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "stamp_updated": 1584179856,
                "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
            }
        },
        "fileshistory": {
            "data": [
                {
                    "file_id": 10,
                    "file_uuid": "B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5",
                    "file_name": "Panic.ai",
                    "file_path": "\/Merch\/Panic",
                    "file_title": "Panic",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Panic\/Panic.ai",
                    "file_size": 224497,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5 )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 1,
                    "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                    "file_name": "Stan.mp3",
                    "file_path": "\/Music",
                    "file_title": "Stan",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Stan.mp3",
                    "file_size": 294084,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 683552A6-6315-4EA6-85C2-745A6511C22B )",
                    "file_track": 2,
                    "file_duration": 263,
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 15,
                    "file_uuid": "87D18889-B923-4F6F-9456-BCC7760052C1",
                    "file_name": "Style.psd",
                    "file_path": "\/Merch\/Taylor",
                    "file_title": "Style",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Taylor\/Style.psd",
                    "file_size": 42923,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 87D18889-B923-4F6F-9456-BCC7760052C1 )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "87D18889-B923-4F6F-9456-BCC7760052C1",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 6,
                    "file_uuid": "6F782D8B-F0F3-41CC-BD12-C1785AC3277C",
                    "file_name": "video2.mp4",
                    "file_path": "\/Video",
                    "file_title": "video2",
                    "file_category": "video",
                    "file_sortby": "\/Video\/video2.mp4",
                    "file_size": 296578,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 6F782D8B-F0F3-41CC-BD12-C1785AC3277C )",
                    "track_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                    "track": "Stan",
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "6F782D8B-F0F3-41CC-BD12-C1785AC3277C",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 20,
                    "file_uuid": "87F9A531-FC9F-40D0-B9E1-BE2577865ABD",
                    "file_name": "Files-2.doc",
                    "file_path": "\/Other\/Files",
                    "file_title": "Files-2",
                    "file_category": "other",
                    "file_sortby": "\/Other\/Files\/Files-2.doc",
                    "file_size": 452621,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 87F9A531-FC9F-40D0-B9E1-BE2577865ABD )",
                    "file_history": [
                        {
                            "file_uuid": "87F9A531-FC9F-40D0-B9E1-BE2577865ABD",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 11,
                    "file_uuid": "6A7F364A-BA16-4DDD-AC93-612F57E73C98",
                    "file_name": "22.psd",
                    "file_path": "\/Merch",
                    "file_title": "22",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/22.psd",
                    "file_size": 424907,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 6A7F364A-BA16-4DDD-AC93-612F57E73C98 )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "6A7F364A-BA16-4DDD-AC93-612F57E73C98",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 2,
                    "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                    "file_name": "Marshal Mathers.mp3",
                    "file_path": "\/Music",
                    "file_title": "Marshal",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Marshal Mathers.mp3",
                    "file_size": 270163,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 992540C5-F9CA-420D-9327-7058232DF2B2 )",
                    "file_track": 3,
                    "file_duration": 252,
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 16,
                    "file_uuid": "6267298C-BC14-456E-B3B5-E30407EF4A80",
                    "file_name": "Shake_it_off.ai",
                    "file_path": "\/Merch\/Taylor",
                    "file_title": "Shake_it_off",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Taylor\/Shake_it_off.ai",
                    "file_size": 415981,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 6267298C-BC14-456E-B3B5-E30407EF4A80 )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "6267298C-BC14-456E-B3B5-E30407EF4A80",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 7,
                    "file_uuid": "C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40",
                    "file_name": "video2.mp4",
                    "file_path": "\/Video",
                    "file_title": "video2",
                    "file_category": "video",
                    "file_sortby": "\/Video\/marshal.mp4",
                    "file_size": 195797,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40 )",
                    "track_uuid": "350FE70C-92A9-48EC-8E0C-C21EDFC326C3",
                    "track": "Don't Start Now",
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 21,
                    "file_uuid": "C406184B-3FFA-4DFD-BEEE-EDADED0F075B",
                    "file_name": "files-4.docx",
                    "file_path": "\/Other",
                    "file_title": "files-4",
                    "file_category": "other",
                    "file_sortby": "\/Other\/files-4.docx",
                    "file_size": 213584,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( C406184B-3FFA-4DFD-BEEE-EDADED0F075B )",
                    "file_history": [
                        {
                            "file_uuid": "C406184B-3FFA-4DFD-BEEE-EDADED0F075B",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 12,
                    "file_uuid": "703A32B8-E17B-47C3-8669-ED4362F68434",
                    "file_name": "22.psd",
                    "file_path": "\/Merch\/Panic",
                    "file_title": null,
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Panic\/22.psd",
                    "file_size": 230392,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 703A32B8-E17B-47C3-8669-ED4362F68434 )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "703A32B8-E17B-47C3-8669-ED4362F68434",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 3,
                    "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                    "file_name": "I'm Back.mp3",
                    "file_path": "\/Music",
                    "file_title": "I'm Back",
                    "file_category": "music",
                    "file_sortby": "\/Music\/I'm Back.mp3",
                    "file_size": 41774,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E )",
                    "file_track": 1,
                    "file_duration": 297,
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 17,
                    "file_uuid": "C70F71CD-9091-40B6-A524-1EE9D93E46F5",
                    "file_name": "file-1.doc",
                    "file_path": "\/Other",
                    "file_title": "file-1",
                    "file_category": "other",
                    "file_sortby": "\/Other\/file-1.doc",
                    "file_size": 277047,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( C70F71CD-9091-40B6-A524-1EE9D93E46F5 )",
                    "file_history": [
                        {
                            "file_uuid": "C70F71CD-9091-40B6-A524-1EE9D93E46F5",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 8,
                    "file_uuid": "F10B49EE-D440-4129-A064-2297BE3EEDF4",
                    "file_name": "video3.mp4",
                    "file_path": "\/Video",
                    "file_title": "video3",
                    "file_category": "video",
                    "file_sortby": "\/Video\/video3.mp4",
                    "file_size": 143251,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( F10B49EE-D440-4129-A064-2297BE3EEDF4 )",
                    "track_uuid": "57C1E8AE-8E99-45BB-A84D-F8D61F968D3E",
                    "track": "Lose You To Love Me",
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "F10B49EE-D440-4129-A064-2297BE3EEDF4",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 13,
                    "file_uuid": "3DD9FB96-1711-467A-ABD5-75A2287EECEC",
                    "file_name": "Me!.psd",
                    "file_path": "\/Merch",
                    "file_title": "merch",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Me!.psd",
                    "file_size": 495901,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 3DD9FB96-1711-467A-ABD5-75A2287EECEC )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "3DD9FB96-1711-467A-ABD5-75A2287EECEC",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 4,
                    "file_uuid": "3C08F084-DD6C-45D4-8058-56194196602A",
                    "file_name": "back.mp4",
                    "file_path": "\/Video",
                    "file_title": "back",
                    "file_category": "video",
                    "file_sortby": "\/Video\/back.mp4",
                    "file_size": 107950,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 3C08F084-DD6C-45D4-8058-56194196602A )",
                    "track_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                    "track": "Marshal",
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "3C08F084-DD6C-45D4-8058-56194196602A",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 18,
                    "file_uuid": "0D21E453-0ED9-4E18-8BBE-A454E97389C5",
                    "file_name": "file-1.doc",
                    "file_path": "\/Other\/Files",
                    "file_title": "file-1",
                    "file_category": "other",
                    "file_sortby": "\/Other\/Files\/file-1.doc",
                    "file_size": 257269,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 0D21E453-0ED9-4E18-8BBE-A454E97389C5 )",
                    "file_history": [
                        {
                            "file_uuid": "0D21E453-0ED9-4E18-8BBE-A454E97389C5",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 9,
                    "file_uuid": "4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A",
                    "file_name": "Panic.ai",
                    "file_path": "\/Merch",
                    "file_title": "Panic",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Panic.ai",
                    "file_size": 447387,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 14,
                    "file_uuid": "60FCCF9F-DA47-4473-940F-41D1B7844159",
                    "file_name": "Me!.psd",
                    "file_path": "\/Merch\/Taylor",
                    "file_title": "merch",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Taylor\/Me!.psd",
                    "file_size": 318598,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 60FCCF9F-DA47-4473-940F-41D1B7844159 )",
                    "file_sku": "4225-776-3234",
                    "file_history": [
                        {
                            "file_uuid": "60FCCF9F-DA47-4473-940F-41D1B7844159",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 5,
                    "file_uuid": "D81267FD-B51E-489E-B0D2-19E6F09CBBA4",
                    "file_name": "video1.mp4",
                    "file_path": "\/Video",
                    "file_title": "video1",
                    "file_category": "video",
                    "file_sortby": "\/Video\/back.mp4",
                    "file_size": 228962,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( D81267FD-B51E-489E-B0D2-19E6F09CBBA4 )",
                    "track_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                    "track": "Everyone Like",
                    "file_isrc": "NOX001212345",
                    "file_history": [
                        {
                            "file_uuid": "D81267FD-B51E-489E-B0D2-19E6F09CBBA4",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                },
                {
                    "file_id": 19,
                    "file_uuid": "45283D97-3278-48DF-AA70-7AFAD9E77A0D",
                    "file_name": "Files-2.doc",
                    "file_path": "\/Other",
                    "file_title": "Files-2",
                    "file_category": "other",
                    "file_sortby": "\/Other\/Files-2.doc",
                    "file_size": 403355,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "file_action": "Created",
                    "file_memo": "File( 45283D97-3278-48DF-AA70-7AFAD9E77A0D )",
                    "file_history": [
                        {
                            "file_uuid": "45283D97-3278-48DF-AA70-7AFAD9E77A0D",
                            "file_action": "Created",
                            "stamp_created": 1584179856,
                            "stamp_created_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            },
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": {
                                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                "name_first": "Samuel",
                                "name_middle": "",
                                "name_last": "White"
                            }
                        }
                    ]
                }
            ]
        }
    }
}
```

### HTTP Request
`GET soundblock/project/collection/{collection}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `collection` |  optional  | uuid required Collection UUID
    `file_path` |  optional  | uuid required The file path (/Music, /Music/Sample Folder)
    `file_category` |  optional  | uuid required file_category (music, video, merch, other)
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `collection` | string |  required  | 
        `file_path` | string |  required  | 
    
<!-- END_3bb0755f751ad107a6e44e6d2ee3f04f -->

<!-- START_f7075cb0f751bdc1a9e1c88c17d29083 -->
## soundblock/project/collection/revert
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/revert"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_category": "facere",
    "collection_comment": "sapiente",
    "collection": [],
    "files": [
        {
            "file_uuid": "iusto"
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/collection/revert`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_category` | string |  required  | 
        `collection_comment` | string |  required  | 
        `collection` | array |  required  | 
        `files` | array |  required  | 
        `files.*.file_uuid` | string |  required  | 
    
<!-- END_f7075cb0f751bdc1a9e1c88c17d29083 -->

<!-- START_96ff33cb9dbc33fcd5fae28935f07d79 -->
## soundblock/project/collection/restore
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/restore"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_category": "adipisci",
    "collection": "sit",
    "collection_comment": "provident",
    "files": [
        {
            "file_uuid": "a"
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/collection/restore`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_category` | string |  required  | 
        `collection` | string |  required  | 
        `collection_comment` | string |  required  | 
        `files` | array |  required  | 
        `files.*.file_uuid` | string |  required  | 
    
<!-- END_96ff33cb9dbc33fcd5fae28935f07d79 -->

<!-- START_e36469a4f3186d56e901dbbdeacbdb9f -->
## soundblock/project/collection/file
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/file"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project": "eos",
    "file_category": 20,
    "file": "aut",
    "collection_comment": "aperiam",
    "file_path": "aperiam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "7A9E473F-E9EC-4CEF-9F89-99DA0AB86DA3",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "Once uploaded the music file.",
        "stamp_created": 1584325630,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584325630,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        }
    }
}
```

### HTTP Request
`POST soundblock/project/collection/file`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project` | string |  required  | 
        `file_category` | integer |  required  | 
        `file` | file |  required  | 
        `collection_comment` | string |  required  | 
        `file_path` | string |  required  | 
    
<!-- END_e36469a4f3186d56e901dbbdeacbdb9f -->

<!-- START_88015ad4fe8c2a5893fde766dacdb6fc -->
## soundblock/project/collection/confirm
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/confirm"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project": "natus",
    "file_name": "et",
    "collection_comment": "consectetur",
    "is_zip": false,
    "files": [
        {
            "org_file_sortby": "asperiores",
            "file_title": "possimus",
            "file_name": "commodi",
            "file_track": 12,
            "track": {
                "org_file_sortby": "distinctio",
                "file_uuid": "dicta"
            }
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/collection/confirm`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project` | uuid |  required  | The Project UUID
        `file_name` | string |  required  | Uploaded file name
        `collection_comment` | string |  required  | The collection comment
        `is_zip` | boolean |  required  | Uploaded file is zip or not?
        `files` | array |  required  | The array of files
        `files.*.org_file_sortby` | string |  required  | The orginal file path
        `files.*.file_title` | string |  required  | The file title
        `files.*.file_name` | stirng |  optional  | The file name
        `files.*.file_track` | integer |  optional  | optional Not in 0
        `files.*.track.org_file_sortby` | string |  optional  | optional
        `files.*.track.file_uuid` | uuid |  optional  | optional The track uuid saved already
    
<!-- END_88015ad4fe8c2a5893fde766dacdb6fc -->

<!-- START_b462bfe6844275d237d8b8dde378c3d7 -->
## soundblock/project/collection/files
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/files"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_category": "ratione",
    "files": [
        {
            "file_uuid": "ut",
            "file_name": "voluptatum",
            "file_track": "mollitia",
            "file_title": "magnam"
        }
    ],
    "collection_comment": "laudantium",
    "collection": "consequuntur"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "29D5AD31-D95C-47EA-AFC1-4EC7C5EB75A6",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "Edit file this!!!",
        "stamp_created": 1584323892,
        "stamp_created_by": {
            "uuid": "7C619A2D-9BF6-4F6A-BE96-17285A354344",
            "name_first": "jin",
            "name_middle": "",
            "name_last": "tai"
        },
        "stamp_updated": 1584323892,
        "stamp_updated_by": {
            "uuid": "7C619A2D-9BF6-4F6A-BE96-17285A354344",
            "name_first": "jin",
            "name_middle": "",
            "name_last": "tai"
        }
    }
}
```

### HTTP Request
`PATCH soundblock/project/collection/files`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_category` | string |  required  | music, video, merch, other
        `files` | array |  required  | The file list
        `files.*.file_uuid` | string |  required  | The uuid of file.
        `files.*.file_name` | string |  required  | The name of file
        `files.*.file_track` | string |  optional  | The uuid of music file, This will be required when the file category is "video".
        `files.*.file_title` | string |  optional  | the title of file
        `collection_comment` | string |  required  | 
        `collection` | string |  required  | 
    
<!-- END_b462bfe6844275d237d8b8dde378c3d7 -->

<!-- START_f7eb71592ae01a22fbcda94b18f6332b -->
## soundblock/project/collection/files
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/files"
);

let params = {
    "file_category": "sed",
    "project": "qui",
    "collection_comment": "quis",
    "files[file_uuid]": "deleniti",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_category": "qui",
    "collection": "distinctio",
    "collection_comment": "architecto",
    "files": [
        {
            "file_uuid": "consequuntur"
        }
    ]
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "AA5EA486-5BD0-49D3-AB98-D23399C4F76E",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "Deleted Files",
        "stamp_created": 1584324708,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584324708,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        }
    }
}
```

### HTTP Request
`DELETE soundblock/project/collection/files`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `file_category` |  optional  | file_category required file_category(music, video, other, merch)
    `project` |  optional  | uuid required Project UUID
    `collection_comment` |  optional  | string required The collection comment
    `files` |  optional  | array required The array of files
    `files.file_uuid` |  optional  | uuid required File UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_category` | string |  required  | file_category: "music", "video", "merch", "other"
        `collection` | string |  required  | 
        `collection_comment` | string |  required  | 
        `files` | array |  required  | 
        `files.*.file_uuid` | string |  required  | 
    
<!-- END_f7eb71592ae01a22fbcda94b18f6332b -->

<!-- START_2b99e82398ec4edcd25feadacc49aa99 -->
## soundblock/project/collection/organize-musics
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/organize-musics"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_category": "reprehenderit",
    "collection": "voluptas",
    "collection_comment": "dolorem",
    "files": [
        {
            "file_track": 16,
            "file_uuid": "ut"
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "71E58974-BF4D-40BB-9269-CCC3B862BB71",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "Changed file tracks",
        "stamp_created": 1584325994,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584325994,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        }
    }
}
```

### HTTP Request
`POST soundblock/project/collection/organize-musics`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_category` | string |  required  | 
        `collection` | string |  required  | 
        `collection_comment` | string |  required  | 
        `files` | array |  required  | 
        `files.*.file_track` | integer |  required  | 
        `files.*.file_uuid` | string |  required  | 
    
<!-- END_2b99e82398ec4edcd25feadacc49aa99 -->

<!-- START_e8d3009aa6abec00825cc5c15558f0ae -->
## soundblock/project/collection/{collection}/download
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/1/download"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "collection": "qui",
    "files": [
        {
            "file_uuid": "enim"
        }
    ]
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/collection/{collection}/download`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `collection` | uuid |  required  | Collection UUID
        `files` | array |  required  | The array of files
        `files.*.file_uuid` | File |  optional  | UUID
    
<!-- END_e8d3009aa6abec00825cc5c15558f0ae -->

<!-- START_d32a2047d08e08c977bb9e9af6101472 -->
## soundblock/project/collection/directory
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/directory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "collection": "non",
    "collection_comment": "similique",
    "file_category": "inventore",
    "directory_path": "aspernatur",
    "directory_name": "rerum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "0473B3A3-75B2-4574-90DE-A5C90DE3B870",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "Create Remind Merch Dir Directory!",
        "stamp_created": 1584326141,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584326141,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        }
    }
}
```

### HTTP Request
`POST soundblock/project/collection/directory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `collection` | string |  required  | The uuid of collection
        `collection_comment` | string |  required  | 
        `file_category` | string |  optional  | requried i.e music, video, merch, other
        `directory_path` | string |  required  | i.e /Music/subfolder
        `directory_name` | string |  required  | Folder_Name
    
<!-- END_d32a2047d08e08c977bb9e9af6101472 -->

<!-- START_bf3ba0d0a7fd529451b182fa58531800 -->
## soundblock/project/collection/directory
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/directory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_category": "assumenda",
    "collection": "odit",
    "collection_comment": "aliquid",
    "directory_path": "ratione",
    "directory_name": "odit",
    "new_directory_name": "perferendis"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "AE42ECB2-72B5-42DF-8CEF-9E07DE31912C",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "Rename the directory",
        "stamp_created": 1584326976,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584326976,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        }
    }
}
```

### HTTP Request
`PATCH soundblock/project/collection/directory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_category` | string |  required  | Music, Video, Merch, Other
        `collection` | string |  required  | The uuid of collection
        `collection_comment` | string |  required  | 
        `directory_path` | string |  required  | 
        `directory_name` | string |  required  | 
        `new_directory_name` | string |  required  | 
    
<!-- END_bf3ba0d0a7fd529451b182fa58531800 -->

<!-- START_7463908b2297e6805fb470651132df04 -->
## soundblock/project/collection/directory
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/directory"
);

let params = {
    "project": "ipsa",
    "collection_comment": "tempora",
    "file_category": "ut",
    "directory": "officia",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "collection": "non",
    "collection_comment": "et",
    "file_category": "minima",
    "directory_path": "nisi",
    "directory_name": "in"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "89A8BA01-162C-40BD-85AF-6DA5299765B9",
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "collection_comment": "delete a directory from 75th collection",
        "stamp_created": 1584328318,
        "stamp_created_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584328318,
        "stamp_updated_by": {
            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        }
    }
}
```

### HTTP Request
`DELETE soundblock/project/collection/directory`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `project` |  optional  | uuid requried Project UUID
    `collection_comment` |  optional  | string required The collection comment
    `file_category` |  optional  | file_category required file_category(music, video, merch, other)
    `directory` |  optional  | uuid required Directory UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `collection` | string |  required  | The uuid of collection.
        `collection_comment` | string |  required  | The comment of collection.
        `file_category` | string |  required  | 
        `directory_path` | string |  required  | The uuid of directory.
        `directory_name` | string |  required  | 
    
<!-- END_7463908b2297e6805fb470651132df04 -->

<!-- START_7d8bf1be43762ecf004e6f6bb32a596d -->
## soundblock/project/collection/download/zip/{jobUuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/collection/download/zip/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/collection/download/zip/{jobUuid}`


<!-- END_7d8bf1be43762ecf004e6f6bb32a596d -->

#Core


<!-- START_efa46f5e523e847e935821b8263ecd0b -->
## core/pages
> Example request:

```javascript
const url = new URL(
    "arena.api/core/pages"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/pages`


<!-- END_efa46f5e523e847e935821b8263ecd0b -->

<!-- START_529c505720a92eeca73615d80353ac24 -->
## core/page
> Example request:

```javascript
const url = new URL(
    "arena.api/core/page"
);

let params = {
    "page_url": "aut",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/page`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `app_name` |  required  | App Name
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `page_url` |  required  | Page Url

<!-- END_529c505720a92eeca73615d80353ac24 -->

<!-- START_9e0a99ae77c6a71204c37ea65fb9295c -->
## core/page/{page_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/page/omnis"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/page/{page_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `page_uuid` |  required  | Page UUID

<!-- END_9e0a99ae77c6a71204c37ea65fb9295c -->

<!-- START_a9d22c730daa8e71911f23b49ea67137 -->
## core/page
> Example request:

```javascript
const url = new URL(
    "arena.api/core/page"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "app_name": "ipsam",
    "struct_uuid": "voluptatem",
    "page_url": "et",
    "page_json": "eum",
    "page_title": "ipsum",
    "page_keywords": "quia",
    "page_url_params": {
        "": "rerum"
    },
    "page_description": "vero"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/page`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `app_name` | string |  required  | App Name
        `struct_uuid` | string |  required  | Struct UUID
        `page_url` | string |  required  | Page Url
        `page_json` | string |  required  | Page Json
        `page_title` | string |  required  | Page Title
        `page_keywords` | string |  required  | Page Keywords
        `page_url_params[]` | string |  required  | Page Url Parameters
        `page_description` | string |  required  | Page Description
    
<!-- END_a9d22c730daa8e71911f23b49ea67137 -->

<!-- START_93a92d7ebf38794d537e0a2531505de2 -->
## core/page/{page_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/page/hic"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE core/page/{page_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `page_uuid` |  required  | Page UUID

<!-- END_93a92d7ebf38794d537e0a2531505de2 -->

<!-- START_e0139bf60bf28a793f9d0e4b8a5692ad -->
## core/correspondence/{correspondence_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/correspondence/tempore"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/correspondence/{correspondence_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `correspondence_uuid` |  required  | Correspondence UUID

<!-- END_e0139bf60bf28a793f9d0e4b8a5692ad -->

<!-- START_d0f28c9db1ef43bc92845c1f8bbad2d2 -->
## core/correspondence/{correspondence_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/correspondence/aut"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "flag_read": false,
    "flag_archived": true,
    "flag_received": false
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH core/correspondence/{correspondence_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `correspondence_uuid` |  required  | Correspondence UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `flag_read` | boolean |  optional  | optional Flag Read
        `flag_archived` | boolean |  optional  | optional Flag Archived
        `flag_received` | boolean |  optional  | optional Flag Received
    
<!-- END_d0f28c9db1ef43bc92845c1f8bbad2d2 -->

<!-- START_ce31f910111a6e2bd6e39dd55f6eb52b -->
## core/correspondences
> Example request:

```javascript
const url = new URL(
    "arena.api/core/correspondences"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/correspondences`


<!-- END_ce31f910111a6e2bd6e39dd55f6eb52b -->

<!-- START_cb7e2ccad49b9f714957190c8f2962ad -->
## core/correspondence
> Example request:

```javascript
const url = new URL(
    "arena.api/core/correspondence"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/correspondence`


<!-- END_cb7e2ccad49b9f714957190c8f2962ad -->

<!-- START_c339ccbabe76103594e6cad14d16ae50 -->
## Get Inst Images

> Example request:

```javascript
const url = new URL(
    "arena.api/core/social/instagram"
);

let params = {
    "random": "ut",
    "latest": "eius",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/social/instagram`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `random` |  optional  | Count of Random Images
    `latest` |  optional  | Count of Latest Images

<!-- END_c339ccbabe76103594e6cad14d16ae50 -->

#Deployments


<!-- START_63a88eb4029bf0cb85939ea19fe2497a -->
## office/soundblock/project/{project}/deployments
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/voluptatem/deployments"
);

let params = {
    "sort_platform": "illo",
    "sort_deployment_status": "expedita",
    "sort_stamp_updated": "facilis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "deployment_uuid": "59EE358A-063E-49DD-B584-4EC89F7E8FB6",
            "deployment_status": {
                "deployment_status": "Deployed",
                "deployment_memo": "deployment_memo"
            },
            "distribution": "All Territory",
            "stamp_created": 1584399955,
            "stamp_created_by": {
                "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584399955,
            "stamp_updated_by": {
                "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "platform": {
                "data": {
                    "platform_uuid": "B41E3A54-E9B5-4AAF-A412-9165C262D7A4",
                    "platform_name": "Amazon",
                    "stamp_created": 1584399955,
                    "stamp_created_by": {
                        "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584399955,
                    "stamp_updated_by": {
                        "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        }
    ]
}
```

### HTTP Request
`GET office/soundblock/project/{project}/deployments`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `sort_platform` |  optional  | optional ASC or DESC
    `sort_deployment_status` |  optional  | optional ASC or DESC
    `sort_stamp_updated` |  optional  | optional ASC or DESC

<!-- END_63a88eb4029bf0cb85939ea19fe2497a -->

<!-- START_65645a9012054ae86342566094936499 -->
## office/soundblock/project/deployment
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/deployment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "platform": "beatae",
    "collection": "sapiente"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/soundblock/project/deployment`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `platform` | string |  required  | Platform UUID
        `collection` | string |  required  | Collection UUID
    
<!-- END_65645a9012054ae86342566094936499 -->

<!-- START_47b98e6295facfd95554e0d7bb7cb06b -->
## office/soundblock/project/deployment/{deployment}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/deployment/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "deployment": "aut",
    "deployment_status": "ea"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "deployment_uuid": "4D0C9F52-8228-464C-A102-96552475C884",
        "deployment_status": {
            "deployment_status": "Deployed",
            "deployment_memo": "Deployed( 4D0C9F52-8228-464C-A102-96552475C884 )"
        },
        "distribution": "All Territory",
        "stamp_created": 1584399955,
        "stamp_created_by": {
            "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1584406401,
        "stamp_updated_by": {
            "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        }
    }
}
```

### HTTP Request
`PATCH office/soundblock/project/deployment/{deployment}`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `deployment` | string |  required  | Deployment UUID
        `deployment_status` | string |  required  | Deployment Status (Pending, Deployed, Failed)
    
<!-- END_47b98e6295facfd95554e0d7bb7cb06b -->

<!-- START_c1a73b85d6a32842009d4b6de4af96b9 -->
## soundblock/project/{project}/deployments
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/1/deployments"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/{project}/deployments`


<!-- END_c1a73b85d6a32842009d4b6de4af96b9 -->

<!-- START_6c9d5e16a1623a89e6426f652d08dc25 -->
## soundblock/project/{project}/deploy
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/1/deploy"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "platform": "eligendi",
    "collection": "a"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/{project}/deploy`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `platform` | string |  required  | Platform UUID
        `collection` | string |  required  | Collection UUID
    
<!-- END_6c9d5e16a1623a89e6426f652d08dc25 -->

<!-- START_45ec9cb6c297d423d3649bd3d67a1ca7 -->
## soundblock/project/deploy
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/deploy"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "deployment": "maiores",
    "deployment_status": "quaerat"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "deployment_uuid": "4D0C9F52-8228-464C-A102-96552475C884",
        "deployment_status": {
            "deployment_status": "Deployed",
            "deployment_memo": "Deployed( 4D0C9F52-8228-464C-A102-96552475C884 )"
        },
        "distribution": "All Territory",
        "stamp_created": 1584399955,
        "stamp_created_by": {
            "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1584406401,
        "stamp_updated_by": {
            "uuid": "027CC4FA-8A94-4ACE-932E-1C8222832941",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        }
    }
}
```

### HTTP Request
`PATCH soundblock/project/deploy`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `deployment` | string |  required  | Deployment UUID
        `deployment_status` | string |  required  | Deployment Status (Pending, Deployed, Failed)
    
<!-- END_45ec9cb6c297d423d3649bd3d67a1ca7 -->

#Email Verification


<!-- START_055f1257529ca902fcbb0b8de15a36cf -->
## email/{hash}
> Example request:

```javascript
const url = new URL(
    "arena.api/email/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH email/{hash}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `required` |  optional  | hash

<!-- END_055f1257529ca902fcbb0b8de15a36cf -->

#Merch


<!-- START_fdfc56a046750bb32ebe948a3d30e405 -->
## merch/facecovering/order
> Example request:

```javascript
const url = new URL(
    "arena.api/merch/facecovering/order"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "quae",
    "last_name": "laudantium",
    "organization": "rerum",
    "email": "doloribus",
    "message": "molestias"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST merch/facecovering/order`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `last_name` | string |  required  | 
        `organization` | string |  required  | 
        `email` | string |  required  | 
        `message` | string |  required  | 
    
<!-- END_fdfc56a046750bb32ebe948a3d30e405 -->

<!-- START_917515d2043aada337c344f7a138b07c -->
## merch/tourmask/order
> Example request:

```javascript
const url = new URL(
    "arena.api/merch/tourmask/order"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "temporibus",
    "last_name": "molestiae",
    "organization": "enim",
    "email": "officiis",
    "message": "non"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST merch/tourmask/order`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `last_name` | string |  required  | 
        `organization` | string |  required  | 
        `email` | string |  required  | 
        `message` | string |  required  | 
    
<!-- END_917515d2043aada337c344f7a138b07c -->

#Notification


<!-- START_e7abe1f30f16956ec659749c7906930c -->
## test/notifications
> Example request:

```javascript
const url = new URL(
    "arena.api/test/notifications"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET test/notifications`


<!-- END_e7abe1f30f16956ec659749c7906930c -->

<!-- START_76fa27d2b00a06106c37c172afab82fd -->
## user/notifications
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notifications"
);

let params = {
    "apps": "voluptatem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "notification_uuid": "EDD44695-75D4-411B-A167-FF9BA6FE033A",
            "notification_name": "Notification Name 1",
            "notification_memo": "Notification Memo 1",
            "notification_action": "Notification Actions 1",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583178637,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583178637,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "01D980CA-CE0D-4597-9531-4197EA3FAD0C",
            "notification_name": "Notification Name 2",
            "notification_memo": "Notification Memo 2",
            "notification_action": "Notification Actions 2",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583178637,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583178637,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "28CE085B-3900-483A-9FAC-7A22CBD6B25F",
            "notification_name": "Notification Name 3",
            "notification_memo": "Notification Memo 3",
            "notification_action": "Notification Actions 3",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583178637,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583178637,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "6F6DFC9B-29D3-47F5-8876-A28EE704BB3E",
            "notification_name": "Test Notification",
            "notification_memo": "Test Notification( 6F6DFC9B-29D3-47F5-8876-A28EE704BB3E )",
            "notification_action": "Test Notification Action",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583178790,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583178790,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "BEAD54C3-DF9B-4786-8605-74FC5B2E178B",
            "notification_name": "Test Notification",
            "notification_memo": "Test Notification( BEAD54C3-DF9B-4786-8605-74FC5B2E178B )",
            "notification_action": "Test Notification Action",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583178858,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583178858,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "E2008A76-1142-47CE-9B85-56462CB65C9D",
            "notification_name": "Test Notification",
            "notification_memo": "Test Notification( E2008A76-1142-47CE-9B85-56462CB65C9D )",
            "notification_action": "Test Notification Action",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583183713,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583183713,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "02ECD053-B7DB-414D-A0F8-9D05C7AC8D61",
            "notification_name": "Test Notification",
            "notification_memo": "Test Notification( 02ECD053-B7DB-414D-A0F8-9D05C7AC8D61 )",
            "notification_action": "Test Notification Action",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583183722,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583183722,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "93CF0B37-0A06-4465-A50F-147D144D452C",
            "notification_name": "Test Notification",
            "notification_memo": "Test Notification( 93CF0B37-0A06-4465-A50F-147D144D452C )",
            "notification_action": "Test Notification Action",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583183729,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583183729,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "1E9A4293-5A31-4DB1-8734-E2A823AF3A7A",
            "notification_name": "Test Notification",
            "notification_memo": "Test Notification( 1E9A4293-5A31-4DB1-8734-E2A823AF3A7A )",
            "notification_action": "Test Notification Action",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583183736,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583183736,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        },
        {
            "notification_uuid": "3D5C0FF5-CF42-42AE-85C8-B27DB1369D75",
            "notification_name": "Test Notification",
            "notification_memo": "Test Notification( 3D5C0FF5-CF42-42AE-85C8-B27DB1369D75 )",
            "notification_action": "Test Notification Action",
            "notification_detail": {
                "notification_state": "unread",
                "flag_canarchieve": 0,
                "flag_candelete": 0
            },
            "stamp_created": 1583183743,
            "stamp_created_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89",
            "stamp_updated": 1583183743,
            "stamp_updated_by": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
        }
    ],
    "meta": {
        "pages": {
            "total": 56,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 6,
            "links": {
                "next": "http:\/\/localhost:8000\/user\/notifications?page=2"
            },
            "from": 1
        }
    }
}
```

### HTTP Request
`GET user/notifications`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `apps` |  optional  | string optional app_name, that separated by comma ","

<!-- END_76fa27d2b00a06106c37c172afab82fd -->

<!-- START_91dca2dff04d14785b088da00a0f88bf -->
## user/notifications
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notifications"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE user/notifications`


<!-- END_91dca2dff04d14785b088da00a0f88bf -->

<!-- START_5dbecbdbe59e13f8ef04bf6b885c5748 -->
## user/notification/send
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notification/send"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/notification/send`


<!-- END_5dbecbdbe59e13f8ef04bf6b885c5748 -->

<!-- START_ebd3491b682e3ebe2430c37fcc21bca5 -->
## user/notification/{notification}/archive
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notification/1/archive"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/notification/{notification}/archive`


<!-- END_ebd3491b682e3ebe2430c37fcc21bca5 -->

<!-- START_9204b51e9c0cff882e7ee750e4551278 -->
## user/notification/{notification}/read
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notification/1/read"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/notification/{notification}/read`


<!-- END_9204b51e9c0cff882e7ee750e4551278 -->

<!-- START_2e0691776d1c6f7191416797bba2aff0 -->
## user/notification/setting
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notification/setting"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/notification/setting`


<!-- END_2e0691776d1c6f7191416797bba2aff0 -->

<!-- START_fdff523ff560f4e42bf88f34ac81b138 -->
## user/notification/setting
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notification/setting"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "apps": {
        "apparel": true,
        "arena": false,
        "catalog": true,
        "io": true,
        "merchandising": false,
        "music": true,
        "office": false,
        "soundblock": true
    },
    "play_sound": true,
    "position": "accusantium"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/notification/setting`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `apps.apparel` | boolean |  optional  | optional Flag to enable notifications on Apparel
        `apps.arena` | boolean |  optional  | optional Flag to enable notifications on Arena
        `apps.catalog` | boolean |  optional  | optional Flag to enable notifications on Catalog
        `apps.io` | boolean |  optional  | optional Flag to enable notifications on Io
        `apps.merchandising` | boolean |  optional  | optional Flag to enable notifications on Merchandising
        `apps.music` | boolean |  optional  | optional Flag to enable notifications on Music
        `apps.office` | boolean |  optional  | optional Flag to enable notifications on Office
        `apps.soundblock` | boolean |  optional  | optional Flag to enable notifications on Soundblock
        `play_sound` | boolean |  required  | Flag to play sound
        `position` | string |  required  | Name of position
    
<!-- END_fdff523ff560f4e42bf88f34ac81b138 -->

<!-- START_904ddd5b6331bee77cd96310f8d0ced7 -->
## user/notifications/archive
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notifications/archive"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/notifications/archive`


<!-- END_904ddd5b6331bee77cd96310f8d0ced7 -->

<!-- START_d3ac572c27db0855176dda5749078f8d -->
## user/notifications/notifications
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notifications/notifications"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/notifications/notifications`


<!-- END_d3ac572c27db0855176dda5749078f8d -->

#Office


<!-- START_01a4e6b6deb1debfd9dc35f20700e689 -->
## office/apparel/seo/{category_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/seo/in"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "category_meta_keywords": "ut",
    "category_meta_description": "alias"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/apparel/seo/{category_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `category_uuid` |  required  | Category UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `category_meta_keywords` | string |  optional  | optional Category Meta Keywords
        `category_meta_description` | string |  optional  | optional Category Meta Description
    
<!-- END_01a4e6b6deb1debfd9dc35f20700e689 -->

<!-- START_67a5835b96b674be25e867af09bdd000 -->
## office/apparel/seo
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/seo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "": {
        "category_meta_keywords": "et",
        "category_meta_description": "unde",
        "category_uuid": "necessitatibus"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/apparel/seo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `[category_meta_keywords]` | string |  optional  | optional Category Meta Keywords
        `[category_meta_description]` | string |  optional  | optional Category Meta Description
        `[category_uuid]` | string |  required  | Category UUID
    
<!-- END_67a5835b96b674be25e867af09bdd000 -->

<!-- START_f4c663b1fc7ba85c88fda16b01e6ba47 -->
## office/apparel/seo
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/seo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/apparel/seo`


<!-- END_f4c663b1fc7ba85c88fda16b01e6ba47 -->

<!-- START_3e070b94bc65f65e178fa9458514a01b -->
## office/apparel/product/price
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/product/price"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_uuid": "ipsum",
    "product_price": "nihil",
    "range_min": "inventore",
    "range_max": "aliquam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/apparel/product/price`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product_uuid` | string |  required  | Product UUID
        `product_price` | numeric |  required  | Product New Price
        `range_min` | numeric |  required  | Product New Min Price
        `range_max` | numeric |  required  | Product New Max Price
    
<!-- END_3e070b94bc65f65e178fa9458514a01b -->

<!-- START_9045c17c4f3b4fb3952608e2c91814fc -->
## office/apparel/product/{product_uuid}/price/{price_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/product/voluptatem/price/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE office/apparel/product/{product_uuid}/price/{price_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `product_uuid` |  required  | Product UUID
    `product_price_uuid` |  required  | Product Price UUID

<!-- END_9045c17c4f3b4fb3952608e2c91814fc -->

<!-- START_4291b5735d50427eb2c7001af09609fb -->
## office/apparel/product/{product_uuid}/price/{price_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/product/itaque/price/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_price": "voluptates",
    "range_min": "maiores",
    "range_max": "ipsa"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/apparel/product/{product_uuid}/price/{price_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `product_uuid` |  required  | Product UUID
    `product_price_uuid` |  required  | Product Price UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product_price` | numeric |  required  | Product New Price
        `range_min` | numeric |  required  | Product New Min Price
        `range_max` | numeric |  required  | Product New Max Price
    
<!-- END_4291b5735d50427eb2c7001af09609fb -->

<!-- START_e7f7dda9c7ce9ec52c9f694a99d5e80a -->
## office/apparel/{categoty_uuid}/attributes/{attribute_type}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/1/attributes/ad"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/apparel/{categoty_uuid}/attributes/{attribute_type}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `category_uuid` |  required  | Category UUID
    `attribute_type` |  required  | Attribute Type

<!-- END_e7f7dda9c7ce9ec52c9f694a99d5e80a -->

<!-- START_fc23b7570ce22dc7196fe2cbc65364a1 -->
## office/apparel/attribute
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/attribute"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "category_uuid": "inventore",
    "attribute_name": "tempore",
    "attribute_type": "est"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/apparel/attribute`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `category_uuid` | string |  required  | Category UUID
        `attribute_name` | string |  required  | Attribute Name
        `attribute_type` | string |  required  | Attribute Type
    
<!-- END_fc23b7570ce22dc7196fe2cbc65364a1 -->

<!-- START_6789e75b5c7a5d4cba9b969302c1b888 -->
## office/apparel/products
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/products"
);

let params = {
    "category_uuid": "delectus",
    "sort_field": "incidunt",
    "sort_dir": "non",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/apparel/products`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `category_uuid` |  optional  | string optional Category UUID
    `sort_field` |  optional  | string optional Sort Field (product_name, product_price, )
    `sort_dir` |  optional  | string optional Sort Direction

<!-- END_6789e75b5c7a5d4cba9b969302c1b888 -->

<!-- START_b9441ce8a9dc6124a5acac1e3418fd1c -->
## office/apparel/product/{product_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/product/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/apparel/product/{product_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ProductUUID` |  required  | Product UUID

<!-- END_b9441ce8a9dc6124a5acac1e3418fd1c -->

<!-- START_bbc8af94f56fb39f09d681e3b21afb2f -->
## office/apparel/product/{product_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/product/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE office/apparel/product/{product_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ProductUUID` |  required  | Product UUID

<!-- END_bbc8af94f56fb39f09d681e3b21afb2f -->

<!-- START_fe874d4f551d3018028f46638a084605 -->
## office/apparel/product/{product_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/product/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_name": "dolor",
    "product_description": "dolore",
    "product_weight": "sit",
    "product_meta_keywords": "molestiae",
    "product_meta_description": "exercitationem"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/apparel/product/{product_uuid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ProductUUID` |  required  | Product UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product_name` | string |  optional  | optional Product Name
        `product_description` | string |  optional  | optional Product Description
        `product_weight` | numeric |  optional  | optional Product Weight
        `product_meta_keywords` | string |  optional  | optional Product Meta Keywords
        `product_meta_description` | string |  optional  | optional Product Meta Description
    
<!-- END_fe874d4f551d3018028f46638a084605 -->

<!-- START_69845974db7ec4fa954016bd270cc3bc -->
## office/apparel/product
> Example request:

```javascript
const url = new URL(
    "arena.api/office/apparel/product"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product": {
        "product_name": "iusto",
        "product_description": "temporibus",
        "ascolour_id": 18,
        "product_price": "cum",
        "product_meta_keywords": "sit",
        "product_meta_description": "ipsum",
        "product_weight": "quo"
    },
    "price": {
        "product_price": "corrupti",
        "range_min": "itaque",
        "range_max": "aspernatur"
    },
    "sizes": {
        "": "quibusdam"
    },
    "attribute": {
        "attribute_uuid": "expedita"
    },
    "color": {
        "color_name": "illum",
        "color_hash": "harum"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/apparel/product`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product[product_name]` | string |  required  | Product Name
        `product[product_description]` | string |  required  | Product Description
        `product[ascolour_id]` | integer |  required  | Ascolour id
        `product[product_price]` | numeric |  required  | Product Price
        `product[product_meta_keywords]` | string |  optional  | optional Product Meta Keywords
        `product[product_meta_description]` | string |  optional  | optional Product Meta Description
        `product[product_weight]` | numeric |  required  | Product Weight
        `price[product_price]` | numeric |  required  | Product Price
        `price[range_min]` | numeric |  required  | Product Min Price
        `price[range_max]` | numeric |  required  | Product Max Price
        `sizes[]` | string |  required  | List of Product Sizes
        `attribute[attribute_uuid]` | string |  required  | Attribute UUID
        `color[color_name]` | string |  required  | Color Name
        `color[color_hash]` | string |  required  | Color Hash
    
<!-- END_69845974db7ec4fa954016bd270cc3bc -->

#Payments


<!-- START_dfab5bd9f80016407866161b27ef8965 -->
## office/accounting/charge/rates
> Example request:

```javascript
const url = new URL(
    "arena.api/office/accounting/charge/rates"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/accounting/charge/rates`


<!-- END_dfab5bd9f80016407866161b27ef8965 -->

<!-- START_3eef6f3b13522aed04b470fcf1dcc3f6 -->
## office/accounting/charge/rates
> Example request:

```javascript
const url = new URL(
    "arena.api/office/accounting/charge/rates"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "rates": {
        "contract": 530.49071,
        "user": 65914206.674,
        "download": 1284149.772282,
        "upload": 274
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/accounting/charge/rates`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `rates[contract]` | float |  required  | Rate For Contract
        `rates[user]` | float |  required  | Rate For User
        `rates[download]` | float |  required  | Rate For Download
        `rates[upload]` | float |  required  | Rate For Upload
    
<!-- END_3eef6f3b13522aed04b470fcf1dcc3f6 -->

<!-- START_816c65616b1f83abd720fbf3ed788286 -->
## office/type/rate
> Example request:

```javascript
const url = new URL(
    "arena.api/office/type/rate"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/type/rate`


<!-- END_816c65616b1f83abd720fbf3ed788286 -->

<!-- START_cddcbcf1875de0799fd33dd4852982ce -->
## office/type/rate
> Example request:

```javascript
const url = new URL(
    "arena.api/office/type/rate"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "rates": {
        "contract": 1523.7007,
        "user": 7611.3,
        "download": 24.356585,
        "upload": 5881.7
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/type/rate`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `rates[contract]` | float |  required  | Rate For Contract
        `rates[user]` | float |  required  | Rate For User
        `rates[download]` | float |  required  | Rate For Download
        `rates[upload]` | float |  required  | Rate For Upload
    
<!-- END_cddcbcf1875de0799fd33dd4852982ce -->

<!-- START_502a5818298f1eb8c5f8ce77eec78710 -->
## soundblock/service/plan
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service/plan"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "service_name": "inventore",
    "type": "facere",
    "payment_id": "pm_****"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/service/plan`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `service_name` | required |  optional  | string The Service name
        `type` | string |  required  | Type of service plan (Smart or Simple)
        `payment_id` | string |  required  | The id of stripe payment method.
    
<!-- END_502a5818298f1eb8c5f8ce77eec78710 -->

<!-- START_a7f2086ed508d1f9e659abe52e695130 -->
## soundblock/service/plan
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service/plan"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "consectetur",
    "payment_id": "pm_****",
    "zip": 10
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/service/plan`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `type` | string |  required  | Type of service plan (Smart or Simple)
        `payment_id` | string |  required  | The id of stripe payment method.
        `zip` | integer |  required  | Zip Code
    
<!-- END_a7f2086ed508d1f9e659abe52e695130 -->

<!-- START_07a84d3b68b3c5645469b2a4233143de -->
## soundblock/service/plan/cancel
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service/plan/cancel"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/service/plan/cancel`


<!-- END_07a84d3b68b3c5645469b2a4233143de -->

<!-- START_524f015042149fdc6bf0d1f7518770ff -->
## account/payments/method
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/account/payments/method"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "payment_id": "pm_****"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (201):

```json
null
```

### HTTP Request
`POST account/payments/method`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `payment_id` | string |  required  | The id of stripe payment method.
    
<!-- END_524f015042149fdc6bf0d1f7518770ff -->

<!-- START_e5b5273c42e467cf9d1e674b254111df -->
## account/payments/method
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/account/payments/method"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": "pm_***",
        "object": "payment_method",
        "billing_details": {
            "address": {
                "city": null,
                "country": null,
                "line1": null,
                "line2": null,
                "postal_code": "42424",
                "state": null
            },
            "email": null,
            "name": "rrr",
            "phone": null
        },
        "card": {
            "brand": "visa",
            "checks": {
                "address_line1_check": null,
                "address_postal_code_check": "pass",
                "cvc_check": "pass"
            },
            "country": "US",
            "exp_month": 4,
            "exp_year": 2024,
            "fingerprint": "pIX57eWVvKAplEyK",
            "funding": "credit",
            "generated_from": null,
            "last4": "4242",
            "three_d_secure_usage": {
                "supported": true
            },
            "wallet": null
        },
        "created": 1585509138,
        "customer": "cus_***",
        "livemode": false,
        "metadata": [],
        "type": "card"
    }
]
```

### HTTP Request
`GET account/payments/method`


<!-- END_e5b5273c42e467cf9d1e674b254111df -->

<!-- START_7bed6f18e5f4912b054aad78517e4c4e -->
## account/payments/method/{methodId?}
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/account/payments/method/pm_****. If not provided remove all customer payment methods"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (204):

```json
null
```

### HTTP Request
`DELETE account/payments/method/{methodId?}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `methodId` |  optional  | The id of stripe payment method.

<!-- END_7bed6f18e5f4912b054aad78517e4c4e -->

<!-- START_50e6e9942e2dc0351fabc2de7a50e918 -->
## account/payments/method/default/{methodId}
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "arena.api/account/payments/method/default/pm_****."
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (204):

```json
null
```

### HTTP Request
`PUT account/payments/method/default/{methodId}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `methodId` |  required  | The id of stripe payment method.

<!-- END_50e6e9942e2dc0351fabc2de7a50e918 -->

<!-- START_e9a86f1f9aeaac592bbc50dfac243936 -->
## account/user/service
> Example request:

```javascript
const url = new URL(
    "arena.api/account/user/service"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE account/user/service`


<!-- END_e9a86f1f9aeaac592bbc50dfac243936 -->

#Platform

APIs for Platform
<!-- START_86fc4bc3b6e7e85a81250d1225839cd1 -->
## soundblock/platforms
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/platforms"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "platform_uuid": "3F623BD1-8B26-4661-83EB-394B55154F5C",
            "platform_name": "Apple Music",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "E7254EB6-DE54-4A00-8544-F16B5F007283",
            "platform_name": "Pandora",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "DD9646D4-47F4-47BB-A069-76336071DFF1",
            "platform_name": "Arena",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "D91231DF-D782-4AAD-A176-5264232B4CBC",
            "platform_name": "Spotify",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "C16EDE84-7438-4E61-BF17-B3252906F656",
            "platform_name": "iHeartRadio",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "B13FBD8C-2F29-45C7-9641-CF238E502132",
            "platform_name": "YouTube",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "82840716-2D1F-49C1-A100-F8FE04089C74",
            "platform_name": "Juno Download",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "3AF2D0A0-AC84-446C-8D51-F7CA921CEB94",
            "platform_name": "SHAZAM",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "EFEEE16F-FDCA-4886-ACD1-300406910FD1",
            "platform_name": "Deezer",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "6AE4AB0C-CE07-4C7C-AB0E-CDFD07BAB5BA",
            "platform_name": "Soundcloud",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "191B9438-C0E9-48AE-A652-29D4E80CA53E",
            "platform_name": "Amazon Music",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "EC1E82B6-3942-4B44-B281-BE07A2340A47",
            "platform_name": "Amazon",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "24D456CC-1044-4125-A86A-C8F0D0C1A93E",
            "platform_name": "Google Play",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "BDF0DE87-B58F-4CC1-AED3-9E6A606FDAF0",
            "platform_name": "Dubset",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "C50C1F5A-3BB9-4B12-9C65-7A517CFCE615",
            "platform_name": "Slacker Radio",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "EC951BA2-F67F-44AA-A0C9-AC04ECB76B13",
            "platform_name": "Uma Music",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "1A017228-1205-4727-828E-8135FE9C8F4B",
            "platform_name": "Bandcamp",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "39EB9499-F545-4C95-ABFB-3B9459A434F3",
            "platform_name": "Digital",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "EA613404-2E20-4FA3-9901-E14F40C93A9E",
            "platform_name": "Akazoo",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "36ED2E70-B0A9-43FA-9364-138F52A602D9",
            "platform_name": "Audible Magic",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "55CFAF22-8503-43E8-A505-4919BA0C93BB",
            "platform_name": "Napster",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "D6EC82E6-5198-478F-9648-A9C274575C27",
            "platform_name": "Shopify",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "2FC8D14F-9902-411E-803D-8BF7CFDD7182",
            "platform_name": "TikTok",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "A7FD721F-3FEE-45B3-BCB9-337BE4A39D61",
            "platform_name": "Traxsource",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "4FF5ADCC-A3A5-47A1-8A0E-CDB2DAF6407F",
            "platform_name": "Apple Music",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "127C91CC-9090-4D8F-83A6-698C177CBB2E",
            "platform_name": "Pandora",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "EA3A81CF-3869-445B-8845-77E61AB687C2",
            "platform_name": "Arena",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "3F43C38D-4C8B-4EA8-8CC0-C7A3B5346287",
            "platform_name": "Spotify",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "70528455-35ED-4C16-B2DF-94355524365D",
            "platform_name": "iHeartRadio",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "AF883124-DA64-4C31-9B3A-6E84C2A59E52",
            "platform_name": "YouTube",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "BFC33104-D591-431E-8D54-F9A54B19B4D1",
            "platform_name": "Juno Download",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "C67E7B84-58AF-480F-B9DA-7B6889387500",
            "platform_name": "SHAZAM",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "37197AA9-9F71-4AB6-9EBB-00CE9599FD4E",
            "platform_name": "Deezer",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "BB6D6202-D4C6-44E9-BFD5-B4377F58C482",
            "platform_name": "Soundcloud",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "D3E26C23-B8F6-47EB-8B9C-254B0DDD9EF6",
            "platform_name": "Amazon Music",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "3420354F-E983-4D7A-9048-477DB7335B42",
            "platform_name": "Amazon",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "AB3C4F49-3227-4676-A181-09165554D2DC",
            "platform_name": "Google Play",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "EE8FE392-0DDF-4361-B0DF-944E7B89E39F",
            "platform_name": "Dubset",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "DDEE8945-2CFF-4C86-8925-2A54715D7B0C",
            "platform_name": "Slacker Radio",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "E002243E-1D52-43BB-BFEE-E25C8690FA1B",
            "platform_name": "Uma Music",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "C0A81653-DDB7-4D0C-9993-59A438437E5B",
            "platform_name": "Bandcamp",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "18C1B9B0-12C6-443B-859A-20E1F5CF0DB6",
            "platform_name": "Digital",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "F992AF29-0FE0-477C-9DC5-F1C90F61A722",
            "platform_name": "Akazoo",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "4D6D4A36-66B7-423B-91AF-F7A2D595BFAC",
            "platform_name": "Audible Magic",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "B1F936BA-90C3-4835-9720-8AA58F4EC19C",
            "platform_name": "Napster",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "B62095B1-5CC6-42B7-9888-E6AB691D1314",
            "platform_name": "Shopify",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "FDAE533D-268E-4785-B7B3-F934345C2023",
            "platform_name": "TikTok",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        {
            "platform_uuid": "EE79BEBE-FEEA-4442-9530-74553C87A043",
            "platform_name": "Traxsource",
            "stamp_created": 1584179856,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179856,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        }
    ]
}
```

### HTTP Request
`GET soundblock/platforms`


<!-- END_86fc4bc3b6e7e85a81250d1225839cd1 -->

#Project


<!-- START_d8e367e85a0bbd3fbb286cd1d39c49e0 -->
## office/soundblock/project/{project}/members
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/et/members"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/soundblock/project/{project}/members`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID.

<!-- END_d8e367e85a0bbd3fbb286cd1d39c49e0 -->

<!-- START_c3e535a5324b7493b1c47a9591791602 -->
## office/soundblock/project/{project}/member
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/aut/member"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "veniam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/soundblock/project/{project}/member`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | string |  required  | User UUID
    
<!-- END_c3e535a5324b7493b1c47a9591791602 -->

<!-- START_50de14b4d15c9c1d1c2de95a1eac095f -->
## office/soundblock/project/{project}/member/user
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/doloribus/member/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name_first": "distinctio",
    "name_middle": "ipsa",
    "name_last": "aspernatur",
    "email": "reiciendis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/soundblock/project/{project}/member/user`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name_first` | string |  required  | User First Name
        `name_middle` | string |  optional  | User Middle Name
        `name_last` | string |  optional  | User Last Name
        `email` | string |  required  | User Email
    
<!-- END_50de14b4d15c9c1d1c2de95a1eac095f -->

<!-- START_1a96aa74788873fcfce781c62f7603ac -->
## office/soundblock/project/{project}/member/{user}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/commodi/member/et"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE office/soundblock/project/{project}/member/{user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID.
    `user` |  required  | User UUID.

<!-- END_1a96aa74788873fcfce781c62f7603ac -->

<!-- START_d00b51db73af2403ebf713a8f8e4be15 -->
## soundblock/project/{project}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "modi",
    "date": "omnis",
    "artwork": "quam",
    "type": "consequuntur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/{project}`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  optional  | The project title
        `date` | date |  optional  | Project Date
        `artwork` | file |  optional  | Artwork Image
        `type` | string |  optional  | The project type
    
<!-- END_d00b51db73af2403ebf713a8f8e4be15 -->

<!-- START_76a979cf05d0b11f5a27f9b793b5ad98 -->
## soundblock/project/{project}/team/member/{user}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/nobis/team/member/voluptatem"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE soundblock/project/{project}/team/member/{user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID
    `user` |  required  | User UUID

<!-- END_76a979cf05d0b11f5a27f9b793b5ad98 -->

<!-- START_9ea46a36df2d1e399dbd791a26120e13 -->
## soundblock/project/{project}/team/members
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/nam/team/members"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "users": {
        "": "aut"
    }
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE soundblock/project/{project}/team/members`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `users[]` | required |  optional  | array Users UUID
    
<!-- END_9ea46a36df2d1e399dbd791a26120e13 -->

<!-- START_364cbc076a0ee331ff48b09e6bdbbfeb -->
## soundblock/project/{project}/contract
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/ea/contract"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/{project}/contract`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID.

<!-- END_364cbc076a0ee331ff48b09e6bdbbfeb -->

<!-- START_ded462131662d41a8f1b36f55bd3226a -->
## soundblock/project/{project}/contract
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/consequatur/contract"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "members": {
        "email": "repellendus",
        "name": "est",
        "payout": 20,
        "role": "architecto"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/{project}/contract`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `members` | array |  required  | Members Data
        `members.email` | string |  required  | User Email
        `members.name` | string |  required  | User Name
        `members.payout` | integer |  required  | User Name
        `members.role` | string |  required  | User Role
    
<!-- END_ded462131662d41a8f1b36f55bd3226a -->

<!-- START_00cb9b84a2a89a76db546198bc865133 -->
## soundblock/project/{project}/contract
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/maxime/contract"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "members": {
        "email": "nesciunt",
        "name": "omnis",
        "payout": 10,
        "role": "alias"
    }
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/project/{project}/contract`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `project` |  required  | Project UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `members` | array |  required  | Members Data
        `members.email` | string |  required  | User Email
        `members.name` | string |  required  | User Name
        `members.payout` | integer |  required  | User Name
        `members.role` | string |  required  | User Role
    
<!-- END_00cb9b84a2a89a76db546198bc865133 -->

<!-- START_b826d56d50521911f8e3a5c28b9b5ee3 -->
## soundblock/project/contract/{contract}/accept
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/contract/ut/accept"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/project/contract/{contract}/accept`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `contract` |  required  | Contract UUID.

<!-- END_b826d56d50521911f8e3a5c28b9b5ee3 -->

<!-- START_776180960168d5f4ec2cf8e3a003281a -->
## soundblock/project/contract/{contract}/reject
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/contract/minima/reject"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/project/contract/{contract}/reject`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `contract` |  required  | Contract UUID.

<!-- END_776180960168d5f4ec2cf8e3a003281a -->

<!-- START_79f3d8ee87b8d9164f0badc529b364fc -->
## soundblock/invite/hash
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/invite/hash"
);

let params = {
    "email": "inventore",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/invite/hash`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `email` |  required  | Invite Email.

<!-- END_79f3d8ee87b8d9164f0badc529b364fc -->

<!-- START_84985b38175b78a83f2c656239de1e1d -->
## soundblock/invite/{inviteHash}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/invite/et"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/invite/{inviteHash}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `inviteHash` |  required  | Invite Hash.

<!-- END_84985b38175b78a83f2c656239de1e1d -->

<!-- START_dff1204be9c50fc455fc013593a84bc9 -->
## soundblock/invite/{inviteHash}/signup
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/invite/commodi/signup"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name_first": "labore",
    "email": "dolores",
    "user_password": "quo",
    "user_password_confirmation": "nihil"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/invite/{inviteHash}/signup`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `inviteHash` |  required  | Invite Hash.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name_first` | string |  required  | User First Name
        `email` | string |  required  | User Email
        `user_password` | string |  required  | User Password
        `user_password_confirmation` | string |  required  | User Password Confirmation
    
<!-- END_dff1204be9c50fc455fc013593a84bc9 -->

<!-- START_6969c406a3c4fea3085465ee9abb623e -->
## soundblock/invite/{inviteHash}/signin
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/invite/1/signin"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "password": "ullam",
    "user": "aperiam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": {
        "auth": {
            "token_type": "Bearer",
            "expires_in": 86400,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNjUwNmVjNmY4MTZmZDI0NmIzYWJkYmRiMjUzNDExM2ZlYWIxZDkwMTc4YzI1ODg4OTkzNTY0NDhmZTlhM2MyMTZhNDBmNzMzOWVkZTAwM2UiLCJpYXQiOjE1ODMyNTI1MjgsIm5iZiI6MTU4MzI1MjUyOCwiZXhwIjoxNTgzMzM4OTI4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.zkg-_azoTnK0z9rs04KWbTpp0A4q3QjI91mgmTuwUVcw-PHc4hLxkJjZrcxN_xqJAD2DEmoMziAD6rjkyPCAGEFUHTuBbY29Ufopfok7X_03cL3PGDMHxeU0J_DAxabDCKFHgjCKMfZBzpcFnyRkKAm_0BmxtOEq9MUDKP-FdS3IEZGsJJcoUBhFpQCbSuADALZEngoGfCl8dFZPcWgy9y_xrV_kadX26s5BuIsgUmsMY4pKPYYwwWGgr1J71N6L5ouiTu-ohZhJXrsTRg-o5hqYBgxSHz__s1qmr93f7v531EkhAc6vBGLlrLocD2L1WnEuir0gDqK2VdO1_UfTB07gfQL5G-oAypiW8lRnBzWO-c5ivqyWaTjlcwgsbMTxMTwXEdSB58BcVQ4fvEyFPttm8NtHxSOjCSTCHfUDhyD0RoVI49WuNEPR1oZf70C4JklyUsvOdTraTs4ADzec9nGj5RXhoMO4RE3z8a1h184xfon6Wyu_kJEXrCTJDZu0SEYHeyVnUk_dM4QQkgilR2ykCQXDOxt1Wqg-mfPRdChD4N7RtSPj1gjQ5HJvdSefeO-mmSewqgKJ0FDqL90sZ2eoAG0MmhA6qYTV37x1LVnm615NsEUmdCd-p9q1CuXRU1HBtgsKbpUb6J4smeRdoW6t76sb7HOKYlISx7xQaCo",
            "refresh_token": "def50200c921033a8e2fee78d48d697eb26088a40cfe2bad9964053f2efa7840fb9af978e2e618c4f0bcf4048db0126f2b0af0b23f099a2f863930ddc48dccf34f41d69975aed4ed34dbba29b5bdf31136002c7333700131238f36746cb9dfcd079ecd2fa35946ac6c01405cb3e0f89649f770e654f6e4bcd2d4678c630c965caa1196ffe400e20f0267d7ecb051ccda2a497df7b7dd24f81548752ca0f85d7165d9c99822767e69e6c35e2beabce829aaf23eff585d46635b472dba707dd6d08157c4369b09d61576602befe8eae08902d74f48e730532a37242e553f3bde1bfaf1d692f51bb4d0a20a2f99da39c22e2bdce077a169a5466c03f725a0678f0be1cb1133dec0d93e29714097aafbadf1236b7b8613684a2d778faeca296000bbabe19b3ca50d7ac1519799465089e19b17427e79d196670f7a92b57c2ae772197dbc96f935f594a45d5f641c8a69b2f525b3e78ff4e987d72e1a05aa41ea4a7971"
        },
        "user": "D4A293C4-4CBE-4DE5-B493-FBC22C0D9B89"
    },
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```
> Example response (417):

```json
{
    "response": {
        "message": "The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.",
        "code": 10,
        "status_code": 500
    },
    "status": {
        "app": "Arena.API",
        "code": 417,
        "message": ""
    }
}
```

### HTTP Request
`POST soundblock/invite/{inviteHash}/signin`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `password` | string |  required  | The password of user
        `user` | string |  required  | The email or name of user
    
<!-- END_6969c406a3c4fea3085465ee9abb623e -->

#Service


APIs for the service.
<!-- START_89961b4623408e4eb3bac0b8211ec3f9 -->
## office/soundblock/service
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/service"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "et",
    "service_name": "dolore"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "04126030-5533-4529-B8BA-9E943DC0740E",
        "service_name": "AAAAPPPP",
        "stamp_created": 1584302409,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": 1584303377,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`POST office/soundblock/service`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | string |  optional  | optional
        `service_name` | string |  required  | 
    
<!-- END_89961b4623408e4eb3bac0b8211ec3f9 -->

<!-- START_c012a2205011e6a46aa63ed884b5544d -->
## office/soundblock/service
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/service"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "service_name": "dignissimos",
    "service_uuid": "omnis"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "04126030-5533-4529-B8BA-9E943DC0740E",
        "service_name": "AAAAPPPP",
        "stamp_created": 1584302409,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": 1584303377,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`PATCH office/soundblock/service`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `service_name` | string |  required  | 
        `service_uuid` | string |  required  | 
    
<!-- END_c012a2205011e6a46aa63ed884b5544d -->

<!-- START_397d1790b5c950499c166fba7e849f5d -->
## office/soundblock/serviceplans
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/serviceplans"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "service_uuid": "FEAC7859-0B32-494C-98AE-4DCAF022D796",
            "service_name": "Service Name 1",
            "stamp_created": 1584499160,
            "stamp_created_by": {
                "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584499160,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            },
            "transactions": {
                "data": [
                    {
                        "transaction_uuid": "C91926FD-4F7B-41D3-80BD-31084B459CC8",
                        "ledger_uuid": "4D42E550-3D9C-4280-B98B-87CB4F8804DD",
                        "transaction_cost": 2,
                        "transaction_name": "download",
                        "transaction_memo": "transaction_memo",
                        "transaction_type": "transaction_type",
                        "stamp_created": 1584499162,
                        "stamp_created_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584499162,
                        "stamp_updated_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            },
            "user": {
                "data": {
                    "user_uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White",
                    "stamp_created": 1584499160,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499160,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "plans": {
                "data": {
                    "plan_uuid": "DCCCE1D6-8F9D-4937-A8BD-3FAB6FA10A67",
                    "ledger_uuid": "168A506A-4014-47B8-8C32-1F40067F5037",
                    "plan_type": "Smart Block Storage",
                    "plan_cost": 4.99,
                    "plan_day": 9,
                    "stamp_created": 1584499162,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499162,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "service_uuid": "70BBFEB8-58AF-460A-808C-540B0F48D49E",
            "service_name": "Service Name 2",
            "stamp_created": 1584499160,
            "stamp_created_by": {
                "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584499160,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            },
            "transactions": {
                "data": [
                    {
                        "transaction_uuid": "B9B90B65-96CF-4120-A3E7-123184C79993",
                        "ledger_uuid": "66C08228-BA7C-4088-A88A-342C78437ADF",
                        "transaction_cost": 2,
                        "transaction_name": "download",
                        "transaction_memo": "transaction_memo",
                        "transaction_type": "transaction_type",
                        "stamp_created": 1584499162,
                        "stamp_created_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584499162,
                        "stamp_updated_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            },
            "user": {
                "data": {
                    "user_uuid": "31D34EAB-F27B-42F5-90FA-11387385D4C0",
                    "name_first": "Damon",
                    "name_middle": "",
                    "name_last": "Evans",
                    "stamp_created": 1584499160,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499160,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "plans": {
                "data": {
                    "plan_uuid": "424901FC-B6CF-4430-9BE1-4D57D9589ABD",
                    "ledger_uuid": "C1E71F50-8AD3-4446-8656-CDDEFD475E05",
                    "plan_type": "Smart Block Storage",
                    "plan_cost": 24.99,
                    "plan_day": 31,
                    "stamp_created": 1584499162,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499162,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "service_uuid": "D29B7782-1BC8-4950-B757-6B2388712214",
            "service_name": "Service Name 3",
            "stamp_created": 1584499160,
            "stamp_created_by": {
                "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584499160,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            },
            "transactions": {
                "data": [
                    {
                        "transaction_uuid": "72B064C3-FC6B-4543-9CE5-051DB722BF6D",
                        "ledger_uuid": "8BDA0FB2-7EE6-40E2-81F5-AB83C852D087",
                        "transaction_cost": 2,
                        "transaction_name": "download",
                        "transaction_memo": "transaction_memo",
                        "transaction_type": "transaction_type",
                        "stamp_created": 1584499162,
                        "stamp_created_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584499162,
                        "stamp_updated_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            },
            "user": {
                "data": {
                    "user_uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                    "name_first": "Yurii",
                    "name_middle": "",
                    "name_last": "Kosiak",
                    "stamp_created": 1584499160,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499160,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "plans": {
                "data": {
                    "plan_uuid": "735EF55B-960F-493E-9089-AE86AB856E1D",
                    "ledger_uuid": "03EBCCDD-493A-4F7F-AD35-5FB367E7F837",
                    "plan_type": "Smart Block Storage",
                    "plan_cost": 24.99,
                    "plan_day": 17,
                    "stamp_created": 1584499162,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499162,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "service_uuid": "359C80DE-5A56-4C83-9CDE-6F141F697DD8",
            "service_name": "Service Name 4",
            "stamp_created": 1584499160,
            "stamp_created_by": {
                "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584499160,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            },
            "transactions": {
                "data": [
                    {
                        "transaction_uuid": "20A03156-A1FD-4A07-9689-C5A23E03A9F1",
                        "ledger_uuid": "6BCF13F1-2C1B-424B-B640-660E81D0665C",
                        "transaction_cost": 2,
                        "transaction_name": "download",
                        "transaction_memo": "transaction_memo",
                        "transaction_type": "transaction_type",
                        "stamp_created": 1584499162,
                        "stamp_created_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584499162,
                        "stamp_updated_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            },
            "user": {
                "data": {
                    "user_uuid": "8AB5D163-5726-4347-AC54-E0E0011FF3B4",
                    "name_first": "jin",
                    "name_middle": "",
                    "name_last": "tai",
                    "stamp_created": 1584499160,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499160,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "plans": {
                "data": {
                    "plan_uuid": "F1DB2FE5-A8BF-456F-9765-595E5A54A2B7",
                    "ledger_uuid": "E1BD1DE6-B316-48B9-B42E-802989AC49C5",
                    "plan_type": "Smart Block Storage",
                    "plan_cost": 4.99,
                    "plan_day": 20,
                    "stamp_created": 1584499162,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499162,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "service_uuid": "2BD52289-8E3E-4EAA-9B36-30C5482AA663",
            "service_name": "Service Name 5",
            "stamp_created": 1584499160,
            "stamp_created_by": {
                "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584499160,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            },
            "transactions": {
                "data": [
                    {
                        "transaction_uuid": "87ED4E9F-5949-4E4B-9B72-9AA1FF50EB41",
                        "ledger_uuid": "786EEEE1-C783-4AAD-9D56-412694D20680",
                        "transaction_cost": 2,
                        "transaction_name": "download",
                        "transaction_memo": "transaction_memo",
                        "transaction_type": "transaction_type",
                        "stamp_created": 1584499162,
                        "stamp_created_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584499162,
                        "stamp_updated_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            },
            "user": {
                "data": {
                    "user_uuid": "FE4EF143-9AB4-4521-9419-D4F867023E93",
                    "name_first": "Lazar",
                    "name_middle": "",
                    "name_last": "Jankovic",
                    "stamp_created": 1584499160,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499160,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "plans": {
                "data": {
                    "plan_uuid": "D7D4683F-AF9A-416B-8412-49597CDDB40D",
                    "ledger_uuid": "AE65FE66-B731-446C-91D9-4D8E74C886E5",
                    "plan_type": "Simple Block Storage",
                    "plan_cost": 24.99,
                    "plan_day": 19,
                    "stamp_created": 1584499162,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499162,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "service_uuid": "F7727DFB-5C0C-40F1-B9BB-429FF9553C4A",
            "service_name": "Service Name 6",
            "stamp_created": 1584499160,
            "stamp_created_by": {
                "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584499160,
            "stamp_updated_by": {
                "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
            },
            "transactions": {
                "data": [
                    {
                        "transaction_uuid": "E00DF46F-B710-4C8A-A801-CC829FDE34F9",
                        "ledger_uuid": "9F7C1226-B928-4F10-8701-48B56814F3A0",
                        "transaction_cost": 2,
                        "transaction_name": "download",
                        "transaction_memo": "transaction_memo",
                        "transaction_type": "transaction_type",
                        "stamp_created": 1584499162,
                        "stamp_created_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584499162,
                        "stamp_updated_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            },
            "user": {
                "data": {
                    "user_uuid": "522489AA-BF99-48E4-8860-659F8445BBCE",
                    "name_first": "Demo",
                    "name_middle": "Test",
                    "name_last": "Dummy",
                    "stamp_created": 1584499160,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499160,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "plans": {
                "data": {
                    "plan_uuid": "37EC5DC0-D5E3-4328-9E84-1D60A051C99C",
                    "ledger_uuid": "14389E8E-6234-479C-97F0-2822C118112A",
                    "plan_type": "Simple Block Storage",
                    "plan_cost": 4.99,
                    "plan_day": 8,
                    "stamp_created": 1584499162,
                    "stamp_created_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584499162,
                    "stamp_updated_by": {
                        "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 6,
            "count": 6,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": [],
            "from": 1
        }
    }
}
```

### HTTP Request
`GET office/soundblock/serviceplans`


<!-- END_397d1790b5c950499c166fba7e849f5d -->

<!-- START_c1433d9c5210ac8910b51ccefc1499f8 -->
## office/soundblock/serviceplan
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/serviceplan"
);

let params = {
    "service": "dolorem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "D29B7782-1BC8-4950-B757-6B2388712214",
        "service_name": "App-Soundblock",
        "stamp_created": 1584499160,
        "stamp_created_by": {
            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1584612085,
        "stamp_updated_by": {
            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
        },
        "user": {
            "data": {
                "user_uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak",
                "stamp_created": 1584499160,
                "stamp_created_by": {
                    "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1584499160,
                "stamp_updated_by": {
                    "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        },
        "plans": {
            "data": {
                "plan_uuid": "735EF55B-960F-493E-9089-AE86AB856E1D",
                "ledger_uuid": "03EBCCDD-493A-4F7F-AD35-5FB367E7F837",
                "plan_type": "Smart Block Storage",
                "plan_cost": 24.99,
                "plan_day": 17,
                "stamp_created": 1584499162,
                "stamp_created_by": {
                    "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1584499162,
                "stamp_updated_by": {
                    "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`GET office/soundblock/serviceplan`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `service` |  optional  | string required

<!-- END_c1433d9c5210ac8910b51ccefc1499f8 -->

<!-- START_1f2684147c258d938f7f94b059dbc2d0 -->
## office/soundblock/serviceplan
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/serviceplan"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "consequuntur",
    "service_name": "dolores"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "04126030-5533-4529-B8BA-9E943DC0740E",
        "service_name": "AAAAPPPP",
        "stamp_created": 1584302409,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": 1584303377,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`POST office/soundblock/serviceplan`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | string |  optional  | optional
        `service_name` | string |  required  | 
    
<!-- END_1f2684147c258d938f7f94b059dbc2d0 -->

<!-- START_d61a2c80931339e9ce7079a2f094a069 -->
## office/soundblock/serviceplan
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/serviceplan"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "service_name": "architecto",
    "service_uuid": "inventore"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "04126030-5533-4529-B8BA-9E943DC0740E",
        "service_name": "AAAAPPPP",
        "stamp_created": 1584302409,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": 1584303377,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`PATCH office/soundblock/serviceplan`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `service_name` | string |  required  | 
        `service_uuid` | string |  required  | 
    
<!-- END_d61a2c80931339e9ce7079a2f094a069 -->

<!-- START_fb94bccf94a8d16851cd37d247d0e69e -->
## soundblock/service
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/service`


<!-- END_fb94bccf94a8d16851cd37d247d0e69e -->

<!-- START_8a2d902132ba8fd5a2b671611ff5b747 -->
## soundblock/service/{service}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service/ut"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "7BC828D1-B645-4A5E-8023-9795D69D335B",
        "service_name": "Service Name 3",
        "stamp_created": 1584179854,
        "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
        "stamp_updated": 1584179854,
        "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
        "plans": {
            "data": {
                "plan_uuid": "DF442637-09FD-47F7-8D53-5F518C937D40",
                "ledger_uuid": "8E9DE74F-4E67-444A-AF24-D5A9471FFAD9",
                "plan_type": "Simple Block Storage",
                "plan_cost": 4.99,
                "plan_day": 22,
                "stamp_created": 1584179856,
                "stamp_created_by": {
                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1584179856,
                "stamp_updated_by": {
                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`GET soundblock/service/{service}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `service` |  required  | string The Service UUID

<!-- END_8a2d902132ba8fd5a2b671611ff5b747 -->

<!-- START_1a9b477059f7459b37e563f6d40ae88b -->
## soundblock/service/{service}/transactions
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service/nisi/transactions"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/service/{service}/transactions`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `service` |  required  | Service UUID

<!-- END_1a9b477059f7459b37e563f6d40ae88b -->

<!-- START_1155020002820d7a8db4422e312b2d54 -->
## soundblock/service
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "exercitationem",
    "service_name": "qui"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "04126030-5533-4529-B8BA-9E943DC0740E",
        "service_name": "AAAAPPPP",
        "stamp_created": 1584302409,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": 1584303377,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`POST soundblock/service`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | string |  optional  | optional
        `service_name` | string |  required  | 
    
<!-- END_1155020002820d7a8db4422e312b2d54 -->

<!-- START_6ba4d82b083b361096ebc2cd4c2c6704 -->
## soundblock/service
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/service"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "service_name": "doloremque",
    "service_uuid": "aspernatur"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "service_uuid": "04126030-5533-4529-B8BA-9E943DC0740E",
        "service_name": "AAAAPPPP",
        "stamp_created": 1584302409,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": 1584303377,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`PATCH soundblock/service`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `service_name` | string |  required  | 
        `service_uuid` | string |  required  | 
    
<!-- END_6ba4d82b083b361096ebc2cd4c2c6704 -->

<!-- START_dd238562fd0485493ed418e48938a1ff -->
## soundblock/reports/service/{service?}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/reports/service/"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/reports/service/{service?}`


<!-- END_dd238562fd0485493ed418e48938a1ff -->

<!-- START_752beb741d1f8a4c694d30153a32e4e4 -->
## soundblock/setting/account
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/setting/account"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/setting/account`


<!-- END_752beb741d1f8a4c694d30153a32e4e4 -->

#Support


<!-- START_4fe618e68b34d7bb9849208fe5f5041e -->
## support/tickets
> Example request:

```javascript
const url = new URL(
    "arena.api/support/tickets"
);

let params = {
    "sort_app": "reprehenderit",
    "sort_support_category": "est",
    "sort_flag_status": "accusamus",
    "flag_status": "ab",
    "per_page": "perferendis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "ticket_uuid": "F06FEF06-10CC-40FA-A0D9-63A094FD4906",
            "user_uuid": "CD858B8B-7C43-422C-9BD6-BA0DE45A7A06",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Ms.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "BF10CF9C-66CA-4543-9CAB-F20ABAF7A7BD",
                    "support_category": "Customer Service",
                    "app_uuid": "A1C2008C-DCC6-48AD-A0FB-A90C088C4839",
                    "app_name": "soundblock",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "D6A3CB6D-D3D7-41FF-A275-46D49DCEFF1B",
            "user_uuid": "CD858B8B-7C43-422C-9BD6-BA0DE45A7A06",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Mr.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "CF3635CC-D08C-41AA-95A3-72A0D2F8491C",
                    "support_category": "Technical Support",
                    "app_uuid": "A1C2008C-DCC6-48AD-A0FB-A90C088C4839",
                    "app_name": "soundblock",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "7E32270F-D09F-4922-AECC-E1750727418D",
            "user_uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Prof.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "CFD48204-5937-44BF-A4AE-1B0BA66E75ED",
                    "support_category": "Feedback",
                    "app_uuid": "A1C2008C-DCC6-48AD-A0FB-A90C088C4839",
                    "app_name": "soundblock",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "A208B83B-100C-47F3-AF76-BA158C69844C",
            "user_uuid": "CD858B8B-7C43-422C-9BD6-BA0DE45A7A06",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Dr.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "CFD48204-5937-44BF-A4AE-1B0BA66E75ED",
                    "support_category": "Feedback",
                    "app_uuid": "A1C2008C-DCC6-48AD-A0FB-A90C088C4839",
                    "app_name": "soundblock",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "24D1C4C1-C4BF-4C7C-B0BA-EA13CD75F017",
            "user_uuid": "CD858B8B-7C43-422C-9BD6-BA0DE45A7A06",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Mrs.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "E369D4DB-BE4B-444C-B84B-E6DE27D18E5F",
                    "support_category": "Customer Service",
                    "app_uuid": "EFC3C30A-6E64-4470-8763-61C37E70DE0F",
                    "app_name": "office",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "B73DCDD0-88B1-4180-B613-632902CBB72D",
            "user_uuid": "94DEDE44-7701-4297-8253-4C5E49A3A863",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Miss",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "E369D4DB-BE4B-444C-B84B-E6DE27D18E5F",
                    "support_category": "Customer Service",
                    "app_uuid": "EFC3C30A-6E64-4470-8763-61C37E70DE0F",
                    "app_name": "office",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "660E9165-3115-402B-848F-EA2B1E0FF37F",
            "user_uuid": "CD858B8B-7C43-422C-9BD6-BA0DE45A7A06",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Miss",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "F0DFEF98-2593-4306-8986-D2E2F6D1C840",
                    "support_category": "Feedback",
                    "app_uuid": "EFC3C30A-6E64-4470-8763-61C37E70DE0F",
                    "app_name": "office",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "2A26CE33-D1CB-4100-B362-6C3FAFD730F6",
            "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Prof.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "56F36BFC-3F1D-436F-A613-07E6AC3B564A",
                    "support_category": "Customer Service",
                    "app_uuid": "C38DB004-2F52-4655-87D5-B29A01B8E8F2",
                    "app_name": "music",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "E880A384-A11C-411C-8BA5-CF779E0A967B",
            "user_uuid": "94DEDE44-7701-4297-8253-4C5E49A3A863",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Dr.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "B10B4E64-33F5-4302-B230-65F36432FEC9",
                    "support_category": "Technical Support",
                    "app_uuid": "C38DB004-2F52-4655-87D5-B29A01B8E8F2",
                    "app_name": "music",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "ticket_uuid": "9FD1D43D-ADB9-4B8F-9491-E1E3622F1D18",
            "user_uuid": "CD858B8B-7C43-422C-9BD6-BA0DE45A7A06",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "ticket_title": "Prof.",
            "flag_status": "Open",
            "stamp_created": 1584633421,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633421,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "support": {
                "data": {
                    "support_uuid": "77A6F8F4-5899-44C3-9A57-2D1DD05DB8E9",
                    "support_category": "Feedback",
                    "app_uuid": "C38DB004-2F52-4655-87D5-B29A01B8E8F2",
                    "app_name": "music",
                    "stamp_created": 1584633424,
                    "stamp_created_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584633424,
                    "stamp_updated_by": {
                        "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 32,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 4,
            "links": {
                "next": "http:\/\/localhost:8000\/support?page=2"
            },
            "from": 1
        }
    }
}
```

### HTTP Request
`GET support/tickets`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `sort_app` |  optional  | string optional asc,desc
    `sort_support_category` |  optional  | string optional asc,desc
    `sort_flag_status` |  optional  | string optional asc,desc
    `flag_status` |  optional  | string optional open, closed, awating user, etc
    `per_page` |  optional  | integer optional 10-100

<!-- END_4fe618e68b34d7bb9849208fe5f5041e -->

<!-- START_b7f1c54b44e7eccd9be74c9875de9d01 -->
## support/ticket/{ticket}
> Example request:

```javascript
const url = new URL(
    "arena.api/support/ticket/1"
);

let params = {
    "ticket": "omnis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET support/ticket/{ticket}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `ticket` |  required  | Support ticker UUID.

<!-- END_b7f1c54b44e7eccd9be74c9875de9d01 -->

<!-- START_3fcb7a717b67f7b50ee8b97fac05c758 -->
## support/ticket
> Example request:

```javascript
const url = new URL(
    "arena.api/support/ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "support": "illo",
    "title": "asperiores",
    "message": "eum",
    "file": "quis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST support/ticket`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `support` | string |  required  | The support category name
        `title` | string |  required  | Ticket title
        `message` | string |  optional  | Ticket message
        `file` | file |  optional  | Ticket Attachment
    
<!-- END_3fcb7a717b67f7b50ee8b97fac05c758 -->

<!-- START_b23f6c02963886f45582e54963272b01 -->
## support/ticket/message
> Example request:

```javascript
const url = new URL(
    "arena.api/support/ticket/message"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ticket": "accusamus",
    "user": "odio",
    "message_text": "distinctio",
    "flag_officeonly": "eum",
    "files": {
        "": []
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST support/ticket/message`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ticket` | uuid |  required  | Ticket UUID
        `user` | uuid |  required  | User UUID
        `message_text` | string |  required  | Message's texxt
        `flag_officeonly` | string |  optional  | required\ Send message only for office users flag
        `files[]` | array |  optional  | optional\ Attachments
    
<!-- END_b23f6c02963886f45582e54963272b01 -->

<!-- START_b7f0f723384af0880170db051455f984 -->
## support/ticket/{ticket}/member
> Example request:

```javascript
const url = new URL(
    "arena.api/support/ticket/tenetur/member"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "ratione",
    "group": "dolorem"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "ticket_uuid": "D7E4FFCE-0425-41C7-A8C3-47FAE9735E53",
        "user": {
            "data": {
                "user_uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        "ticket_title": "Mr.",
        "flag_status": "Closed",
        "stamp_created": 1585362158,
        "stamp_created_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1585362158,
        "stamp_updated_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "support": {
            "data": {
                "support_uuid": "F97E7377-A9BD-4915-9B0B-4980E64C0809",
                "support_category": "Customer Service",
                "app": {
                    "data": {
                        "app_uuid": "2D98B43C-6022-4C6B-BD26-378289555253",
                        "app_name": "apparel"
                    }
                },
                "stamp_created": 1585362158,
                "stamp_created_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1585362158,
                "stamp_updated_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`POST support/ticket/{ticket}/member`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | uuid |  required  | User UUID
        `group` | uuid |  required  | Auth Group UUID
    
<!-- END_b7f0f723384af0880170db051455f984 -->

<!-- START_42bffb7dccfc4437a7bd4755b7328ff8 -->
## support/ticket/{ticket}/members
> Example request:

```javascript
const url = new URL(
    "arena.api/support/ticket/suscipit/members"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "users": {
        "": []
    },
    "groups": {
        "": []
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "ticket_uuid": "D7E4FFCE-0425-41C7-A8C3-47FAE9735E53",
        "user": {
            "data": {
                "user_uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        "ticket_title": "Mr.",
        "flag_status": "Closed",
        "stamp_created": 1585362158,
        "stamp_created_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1585362158,
        "stamp_updated_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "support": {
            "data": {
                "support_uuid": "F97E7377-A9BD-4915-9B0B-4980E64C0809",
                "support_category": "Customer Service",
                "app": {
                    "data": {
                        "app_uuid": "2D98B43C-6022-4C6B-BD26-378289555253",
                        "app_name": "apparel"
                    }
                },
                "stamp_created": 1585362158,
                "stamp_created_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1585362158,
                "stamp_updated_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`POST support/ticket/{ticket}/members`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `users[]` | array |  required  | The array of user UUIDs
        `groups[]` | array |  required  | The array of auth_group UUIDs
    
<!-- END_42bffb7dccfc4437a7bd4755b7328ff8 -->

<!-- START_8a47ed547a9b80239f2dc542d7b1f56c -->
## support/ticket/{ticket}/messages
> Example request:

```javascript
const url = new URL(
    "arena.api/support/ticket/hic/messages"
);

let params = {
    "per_page": "13",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET support/ticket/{ticket}/messages`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `per_page` |  optional  | optional Items per page.

<!-- END_8a47ed547a9b80239f2dc542d7b1f56c -->

<!-- START_0882ca948179919cfc027167eb285c32 -->
## office/support/ticket/{ticket}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket/1"
);

let params = {
    "ticket": "corrupti",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/support/ticket/{ticket}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `ticket` |  required  | Support ticker UUID.

<!-- END_0882ca948179919cfc027167eb285c32 -->

<!-- START_f8f8545f95abfca84fd76badcf93b83e -->
## office/support/ticket
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "support": "ut",
    "title": "placeat",
    "from": "eaque",
    "from_type": "adipisci",
    "to": "dolorem",
    "to_type": "corporis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/support/ticket`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `support` | string |  required  | The support category name
        `title` | string |  required  | Ticket title
        `from` | uuid |  required  | User or Auth Group UUID
        `from_type` | string |  required  | User or Group
        `to` | uuid |  required  | User or Auth Group UUID
        `to_type` | string |  required  | User or Group
    
<!-- END_f8f8545f95abfca84fd76badcf93b83e -->

<!-- START_c2a1d71de533556081a58c669d5627d1 -->
## office/support/ticket
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ticket": "nostrum",
    "flag_status": "ducimus"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/support/ticket`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ticket` | uuid |  required  | Support ticker UUID.
        `flag_status` | string |  required  | Support ticker flag status ("Open", "Closed", "Awating User", "Awating Support").
    
<!-- END_c2a1d71de533556081a58c669d5627d1 -->

<!-- START_f74b288d770c9621d403304679e95a9a -->
## office/support/ticket/message
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket/message"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ticket": "ea",
    "user": "ullam",
    "message_text": "ut",
    "flag_officeonly": "perspiciatis",
    "files": {
        "": []
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/support/ticket/message`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ticket` | uuid |  required  | Ticket UUID
        `user` | uuid |  required  | User UUID
        `message_text` | string |  required  | Message's texxt
        `flag_officeonly` | string |  optional  | required\ Send message only for office users flag
        `files[]` | array |  optional  | optional\ Attachments
    
<!-- END_f74b288d770c9621d403304679e95a9a -->

<!-- START_acc2cdd75b35a01ea3b242aabd039967 -->
## office/support/ticket/{ticket}/messages
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket/accusamus/messages"
);

let params = {
    "per_page": "13",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/support/ticket/{ticket}/messages`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `per_page` |  optional  | optional Items per page.

<!-- END_acc2cdd75b35a01ea3b242aabd039967 -->

<!-- START_ad090f0bbf3c56bfafc0c8fee19e5691 -->
## office/support/ticket/{ticket}/member
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket/error/member"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "aut",
    "group": "sint"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "ticket_uuid": "D7E4FFCE-0425-41C7-A8C3-47FAE9735E53",
        "user": {
            "data": {
                "user_uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        "ticket_title": "Mr.",
        "flag_status": "Closed",
        "stamp_created": 1585362158,
        "stamp_created_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1585362158,
        "stamp_updated_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "support": {
            "data": {
                "support_uuid": "F97E7377-A9BD-4915-9B0B-4980E64C0809",
                "support_category": "Customer Service",
                "app": {
                    "data": {
                        "app_uuid": "2D98B43C-6022-4C6B-BD26-378289555253",
                        "app_name": "apparel"
                    }
                },
                "stamp_created": 1585362158,
                "stamp_created_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1585362158,
                "stamp_updated_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`POST office/support/ticket/{ticket}/member`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | uuid |  required  | User UUID
        `group` | uuid |  required  | Auth Group UUID
    
<!-- END_ad090f0bbf3c56bfafc0c8fee19e5691 -->

<!-- START_f6649cd64bc6e7a83845d240894daab7 -->
## office/support/ticket/{ticket}/members
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket/sed/members"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "users": {
        "": []
    },
    "groups": {
        "": []
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "ticket_uuid": "D7E4FFCE-0425-41C7-A8C3-47FAE9735E53",
        "user": {
            "data": {
                "user_uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        "ticket_title": "Mr.",
        "flag_status": "Closed",
        "stamp_created": 1585362158,
        "stamp_created_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1585362158,
        "stamp_updated_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "support": {
            "data": {
                "support_uuid": "F97E7377-A9BD-4915-9B0B-4980E64C0809",
                "support_category": "Customer Service",
                "app": {
                    "data": {
                        "app_uuid": "2D98B43C-6022-4C6B-BD26-378289555253",
                        "app_name": "apparel"
                    }
                },
                "stamp_created": 1585362158,
                "stamp_created_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1585362158,
                "stamp_updated_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`POST office/support/ticket/{ticket}/members`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `users[]` | array |  required  | The array of user UUIDs
        `groups[]` | array |  required  | The array of auth_group UUIDs
    
<!-- END_f6649cd64bc6e7a83845d240894daab7 -->

<!-- START_68cd216c93e9051528d37498d2709925 -->
## office/support/ticket/{ticket}/member
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket/repudiandae/member"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "ex",
    "group": "eum"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "ticket_uuid": "D7E4FFCE-0425-41C7-A8C3-47FAE9735E53",
        "user": {
            "data": {
                "user_uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        "ticket_title": "Mr.",
        "flag_status": "Closed",
        "stamp_created": 1585362158,
        "stamp_created_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1585362158,
        "stamp_updated_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "support": {
            "data": {
                "support_uuid": "F97E7377-A9BD-4915-9B0B-4980E64C0809",
                "support_category": "Customer Service",
                "app": {
                    "data": {
                        "app_uuid": "2D98B43C-6022-4C6B-BD26-378289555253",
                        "app_name": "apparel"
                    }
                },
                "stamp_created": 1585362158,
                "stamp_created_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1585362158,
                "stamp_updated_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`DELETE office/support/ticket/{ticket}/member`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | uuid |  required  | user UUID
        `group` | uuid |  required  | auth_group UUID
    
<!-- END_68cd216c93e9051528d37498d2709925 -->

<!-- START_9d38f82a12f341e4ce161ba52ebc54a3 -->
## office/support/ticket/{ticket}/members
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/ticket/autem/members"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "users": {
        "": []
    },
    "groups": {
        "": []
    }
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "ticket_uuid": "D7E4FFCE-0425-41C7-A8C3-47FAE9735E53",
        "user": {
            "data": {
                "user_uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            }
        },
        "ticket_title": "Mr.",
        "flag_status": "Closed",
        "stamp_created": 1585362158,
        "stamp_created_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1585362158,
        "stamp_updated_by": {
            "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "support": {
            "data": {
                "support_uuid": "F97E7377-A9BD-4915-9B0B-4980E64C0809",
                "support_category": "Customer Service",
                "app": {
                    "data": {
                        "app_uuid": "2D98B43C-6022-4C6B-BD26-378289555253",
                        "app_name": "apparel"
                    }
                },
                "stamp_created": 1585362158,
                "stamp_created_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1585362158,
                "stamp_updated_by": {
                    "uuid": "7CB4D0E4-AF94-417E-ABD9-73724CA2A71E",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        }
    }
}
```

### HTTP Request
`DELETE office/support/ticket/{ticket}/members`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `ticket` |  required  | Ticket UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `users[]` | array |  required  | The array of user UUIDs
        `groups[]` | array |  required  | The array of auth_group UUIDs
    
<!-- END_9d38f82a12f341e4ce161ba52ebc54a3 -->

#User


<!-- START_be77ebc549fe3d770d65e5f8c83aebf4 -->
## users/avatars
> Example request:

```javascript
const url = new URL(
    "arena.api/users/avatars"
);

let params = {
    "uuids": "est",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET users/avatars`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `uuids` |  required  | Array of Users UUIDs

<!-- END_be77ebc549fe3d770d65e5f8c83aebf4 -->

#User management


APIs for managing users
<!-- START_09a4a3d5f881ee6ac15e4df5783a0c60 -->
## office/users/autocomplete
> Example request:

```javascript
const url = new URL(
    "arena.api/office/users/autocomplete"
);

let params = {
    "user": "veritatis",
    "select_fields": "commodi",
    "select_relations": "ex",
    "aliases_fields": "eos",
    "emails_fields": "et",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "user_uuid": "82391569-6454-44B9-9E89-FA02CEEE15D1",
            "name_first": "jin",
            "name_middle": "",
            "name_last": "tai",
            "stamp_created": 1584419082,
            "stamp_created_by": {
                "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584419082,
            "stamp_updated_by": {
                "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "jintai@arena.com",
                        "stamp_created": 1584419082,
                        "stamp_created_by": {
                            "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584419082,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584419082,
                        "stamp_email_by": {
                            "uuid": "5FB51F97-F406-4F62-B7FA-27A4FFB0D8F7",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        }
                    }
                ]
            },
            "aliases": {
                "data": [
                    {
                        "alias_uuid": "67F79710-DAC6-41A9-AA0C-1B586572A5E4",
                        "user_alias": "jin",
                        "stamp_created": 1584419082,
                        "stamp_created_by": {
                            "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584419082,
                        "stamp_updated_by": {
                            "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    },
                    {
                        "alias_uuid": "6098133E-5283-494C-8A6E-62AAE993AF2A",
                        "user_alias": "jtai",
                        "stamp_created": 1584419082,
                        "stamp_created_by": {
                            "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584419082,
                        "stamp_updated_by": {
                            "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    },
                    {
                        "alias_uuid": "0E986A50-A085-4CA0-A06E-01210D6F3E44",
                        "user_alias": "Jintai",
                        "stamp_created": 1584419082,
                        "stamp_created_by": {
                            "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584419082,
                        "stamp_updated_by": {
                            "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            }
        }
    ]
}
```

### HTTP Request
`GET office/users/autocomplete`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | User Email or Alias.
    `select_fields` |  optional  | The list of fields that will selected. Fields: name - group_name, memo - group_memo, is_critical - flag_critical, group - group_uuid, auth - auth_uuid. E.g select_fields=name,memo
    `select_relations` |  optional  | The list of relations that will selected. Accept: emails, aliases. E.g select_relations=emails,aliases
    `aliases_fields` |  optional  | The list of fields that will selected from alias relation. Fields: alias - user_alias, primary - flag_primary E.g aliases_fields=alias,primary
    `emails_fields` |  optional  | The list of fields that will selected from email relation. Fields: email - user_auth_email, primary - flag_primary E.g emails_fields=emails,aliases

<!-- END_09a4a3d5f881ee6ac15e4df5783a0c60 -->

<!-- START_eb24ac841870b423f17690e734f77ab9 -->
## office/user/{user}/alias
> Example request:

```javascript
const url = new URL(
    "arena.api/office/user/rerum/alias"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "alias": "ut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/user/{user}/alias`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | User UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `alias` | uuid |  required  | Alias Name.
    
<!-- END_eb24ac841870b423f17690e734f77ab9 -->

<!-- START_e60e46f8396e8e6b1e276abc3286cd18 -->
## User Security

> Example request:

```javascript
const url = new URL(
    "arena.api/office/user/eius/security"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "old_password": "soluta",
    "password": "provident",
    "password_confirmation": "sunt",
    "g2fa": true,
    "force_reset": false
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/user/{user}/security`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | User UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `old_password` | string |  optional  | Old Password.
        `password` | string |  optional  | New Password.
        `password_confirmation` | string |  optional  | Confirmation of New Password.
        `g2fa` | boolean |  optional  | Flag of enabled 2fa.
        `force_reset` | boolean |  optional  | Flag of forcing resets password.
    
<!-- END_e60e46f8396e8e6b1e276abc3286cd18 -->

<!-- START_2e3974ae42253973dcdb0b16b027872c -->
## Update the specified resource in storage.

> Example request:

```javascript
const url = new URL(
    "arena.api/office/user/non"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name_first": "blanditiis",
    "name_middle": "ratione",
    "name_last": "dicta"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/user/{user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | User UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name_first` | string |  optional  | optional User First Name.
        `name_middle` | string |  optional  | optional User Middle Name.
        `name_last` | string |  optional  | optional User Last Name.
    
<!-- END_2e3974ae42253973dcdb0b16b027872c -->

<!-- START_89966bfb9ab533cc3249b91a9090d3dc -->
## users
> Example request:

```javascript
const url = new URL(
    "arena.api/users"
);

let params = {
    "user": "sequi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "user_uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "swhite",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "swhite@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            },
            "avatar": {
                "data": {
                    "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                    "stamp_created": 1584835702,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835702,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "user_uuid": "AA794C4B-7F82-4ECB-8E49-34DA6B1BCBF2",
            "name_first": "Damon",
            "name_middle": "",
            "name_last": "Evans",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "Damon",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "devans@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "BF31686F-8E5E-4504-B714-FE6BF1403E13",
                            "name_first": "Lazar",
                            "name_middle": "",
                            "name_last": "Jankovic"
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "CEDDE29C-ED54-410B-A7FA-C283AED8D56C",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "yurii",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "ykosiak@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "AA794C4B-7F82-4ECB-8E49-34DA6B1BCBF2",
                            "name_first": "Damon",
                            "name_middle": "",
                            "name_last": "Evans"
                        }
                    }
                ]
            },
            "avatar": {
                "data": {
                    "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                    "stamp_created": 1584835702,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835702,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "user_uuid": "DFD1E120-7ED2-419F-8B5A-BFDBBB4DC45D",
            "name_first": "jin",
            "name_middle": "",
            "name_last": "tai",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "Jintai",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "jintai@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "CEDDE29C-ED54-410B-A7FA-C283AED8D56C",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        }
                    }
                ]
            },
            "avatar": {
                "data": {
                    "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                    "stamp_created": 1584835702,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835702,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        },
        {
            "user_uuid": "BF31686F-8E5E-4504-B714-FE6BF1403E13",
            "name_first": "Lazar",
            "name_middle": "",
            "name_last": "Jankovic",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "Lazar",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "lazar@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "DFD1E120-7ED2-419F-8B5A-BFDBBB4DC45D",
                            "name_first": "jin",
                            "name_middle": "",
                            "name_last": "tai"
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "DC81003D-4A6A-4C33-A112-43AF934A05D1",
            "name_first": "Demo",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "demo",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "demo@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "BF31686F-8E5E-4504-B714-FE6BF1403E13",
                            "name_first": "Lazar",
                            "name_middle": "",
                            "name_last": "Jankovic"
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "19E478D6-6AF1-4184-B48E-423BC716A782",
            "name_first": "Jacky",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "jacky",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "jacky@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "BF31686F-8E5E-4504-B714-FE6BF1403E13",
                            "name_first": "Lazar",
                            "name_middle": "",
                            "name_last": "Jankovic"
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "E002B043-BC4D-4B64-9EB7-C4C5B4D7F4E5",
            "name_first": "Ace",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "ace",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "ace@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "BF31686F-8E5E-4504-B714-FE6BF1403E13",
                            "name_first": "Lazar",
                            "name_middle": "",
                            "name_last": "Jankovic"
                        }
                    }
                ]
            }
        },
        {
            "user_uuid": "7290856B-12F7-493D-8795-2647E87711F4",
            "name_first": "Polo",
            "name_middle": "Test",
            "name_last": "Dummy",
            "stamp_created": 1584835698,
            "stamp_created_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584835698,
            "stamp_updated_by": {
                "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "aliases": {
                "data": {
                    "user_alias": "polo",
                    "flag_primary": 1,
                    "stamp_created": 1584835699,
                    "stamp_created_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584835699,
                    "stamp_updated_by": {
                        "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "emails": {
                "data": [
                    {
                        "user_auth_email": "polo@arena.com",
                        "stamp_created": 1584835699,
                        "stamp_created_by": {
                            "uuid": "30F4C991-9FF5-47DF-A1BB-ACF5A10901DE",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584835699,
                        "stamp_updated_by": {
                            "uuid": "C621B410-7011-4611-B8A3-46704EFA062B"
                        },
                        "stamp_email": 1584835699,
                        "stamp_email_by": {
                            "uuid": "BF31686F-8E5E-4504-B714-FE6BF1403E13",
                            "name_first": "Lazar",
                            "name_middle": "",
                            "name_last": "Jankovic"
                        }
                    }
                ]
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 9,
            "count": 9,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": [],
            "from": 1
        }
    }
}
```

### HTTP Request
`GET users`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | string optional The uuid of the user.

<!-- END_89966bfb9ab533cc3249b91a9090d3dc -->

<!-- START_210b1af6995fdbf20255888917c7208e -->
## user/avatar
> Example request:

```javascript
const url = new URL(
    "arena.api/user/avatar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST user/avatar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file` | file |  required  | User Avatar
    
<!-- END_210b1af6995fdbf20255888917c7208e -->

<!-- START_2d151e4f213ea4285d4eddeb34df87c3 -->
## user/avatar/{user_uuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/user/avatar/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/avatar/{user_uuid}`


<!-- END_2d151e4f213ea4285d4eddeb34df87c3 -->

<!-- START_ba597cf421c44a2ef22caeea70ea1a55 -->
## user/account
> Example request:

```javascript
const url = new URL(
    "arena.api/user/account"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "alias": "necessitatibus",
    "email": "ad",
    "password": "eligendi",
    "confirm_password": "facilis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST user/account`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `alias` | string |  required  | The user alias
        `email` | required |  optional  | The user email
        `password` | string |  required  | 
        `confirm_password` | string |  required  | 
    
<!-- END_ba597cf421c44a2ef22caeea70ea1a55 -->

<!-- START_630ac44e755e7d9b706ff02b7168d7c7 -->
## User Security

> Example request:

```javascript
const url = new URL(
    "arena.api/account/user/voluptatem/security"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "old_password": "voluptatem",
    "password": "ea",
    "password_confirmation": "illo",
    "g2fa": false,
    "force_reset": true
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH account/user/{user}/security`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | User UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `old_password` | string |  optional  | Old Password.
        `password` | string |  optional  | New Password.
        `password_confirmation` | string |  optional  | Confirmation of New Password.
        `g2fa` | boolean |  optional  | Flag of enabled 2fa.
        `force_reset` | boolean |  optional  | Flag of forcing resets password.
    
<!-- END_630ac44e755e7d9b706ff02b7168d7c7 -->

<!-- START_ed96b64fd3e8eb9a2eefb0a8b90fe08a -->
## Update the specified resource in storage.

> Example request:

```javascript
const url = new URL(
    "arena.api/account/user/consequatur"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name_first": "ea",
    "name_middle": "iure",
    "name_last": "explicabo"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH account/user/{user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | User UUID.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name_first` | string |  optional  | optional User First Name.
        `name_middle` | string |  optional  | optional User Middle Name.
        `name_last` | string |  optional  | optional User Last Name.
    
<!-- END_ed96b64fd3e8eb9a2eefb0a8b90fe08a -->

#general


<!-- START_f21cd17008172195f6a8cbb95e0adb9e -->
## office/support/tickets
> Example request:

```javascript
const url = new URL(
    "arena.api/office/support/tickets"
);

let params = {
    "sort_app": "in",
    "sort_support_category": "autem",
    "sort_flag_status": "quasi",
    "flag_status": "quia",
    "per_page": "delectus",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/support/tickets`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `sort_app` |  optional  | string optional asc,desc
    `sort_support_category` |  optional  | string optional asc,desc
    `sort_flag_status` |  optional  | string optional asc,desc
    `flag_status` |  optional  | string optional open, closed, awating user, etc
    `per_page` |  optional  | integer optional 10-100

<!-- END_f21cd17008172195f6a8cbb95e0adb9e -->

<!-- START_5152ee8a016c858318a3241411710497 -->
## office/contact
> Example request:

```javascript
const url = new URL(
    "arena.api/office/contact"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "accusantium",
    "last_name": "assumenda"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/contact`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `last_name` | string |  required  | 
    
<!-- END_5152ee8a016c858318a3241411710497 -->

<!-- START_62fd5390ed660802322508242aeed408 -->
## office/contacts
> Example request:

```javascript
const url = new URL(
    "arena.api/office/contacts"
);

let params = {
    "user": "quia",
    "flag_read": "inventore",
    "flag_archive": "magni",
    "flag_delete": "praesentium",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/contacts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | uuid required User UUID
    `flag_read` |  optional  | boolean optional
    `flag_archive` |  optional  | boolean optional
    `flag_delete` |  optional  | boolean optional

<!-- END_62fd5390ed660802322508242aeed408 -->

<!-- START_97866ca050f0d6bfd34e3cf03d45b05b -->
## office/contact/{contact}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/contact/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/contact/{contact}`


<!-- END_97866ca050f0d6bfd34e3cf03d45b05b -->

<!-- START_2d43e3fde1653a16f0620d2e7624e17f -->
## office/contact/{contact}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/contact/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/contact/{contact}`


<!-- END_2d43e3fde1653a16f0620d2e7624e17f -->

<!-- START_479661528c2decc374f6396c6bc124d1 -->
## office/soundblock/serviceplan/notes
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/serviceplan/notes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "service": "labore",
    "service_notes": "ratione",
    "user": "in"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "note_uuid": "98F10B83-23A1-49AA-B2FE-FF32C8762EE7",
        "service_uuid": "D7CB5D20-F47C-49DA-834E-EC1326696827",
        "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
        "service_notes": "Remind me project",
        "stamp_created": 1584633634,
        "stamp_created_by": {
            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584633634,
        "stamp_updated_by": {
            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "attachments": {
            "data": [
                {
                    "attachment_url": "http:\/\/localhost:8000\/office\/soundblock\/service\/notes",
                    "stamp_created": 1584633634,
                    "stamp_created_by": {
                        "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                        "name_first": "Yurii",
                        "name_middle": "",
                        "name_last": "Kosiak"
                    },
                    "stamp_updated": 1584633634,
                    "stamp_updated_by": {
                        "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                        "name_first": "Yurii",
                        "name_middle": "",
                        "name_last": "Kosiak"
                    }
                }
            ]
        }
    }
}
```

### HTTP Request
`POST office/soundblock/serviceplan/notes`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `service` | string |  required  | 
        `service_notes` | string |  required  | 
        `user` | string |  required  | 
    
<!-- END_479661528c2decc374f6396c6bc124d1 -->

<!-- START_128dd0ab6f6d26c8095568055739c704 -->
## office/soundblock/serviceplan/notes
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/serviceplan/notes"
);

let params = {
    "service": "ut",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "note_uuid": "C5287253-4BD1-44A1-B66D-406F6735F42F",
            "service_uuid": "D7CB5D20-F47C-49DA-834E-EC1326696827",
            "service_notes": "Sunt rem nihil quia corrupti. Aut voluptatem aut ut distinctio et recusandae ratione. Perspiciatis reiciendis sunt aut pariatur aspernatur impedit.",
            "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "stamp_created": 1584633424,
            "stamp_created_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584633424,
            "stamp_updated_by": {
                "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "attachments": {
                "data": [
                    {
                        "attachment_url": "http:\/\/www.zemlak.com\/ut-voluptates-quia-exercitationem-eos-voluptas-aut-sint",
                        "stamp_created": 1584633424,
                        "stamp_created_by": {
                            "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584633424,
                        "stamp_updated_by": {
                            "uuid": "9B44416E-45AE-4B09-B46B-9C1282047622",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                ]
            }
        },
        {
            "note_uuid": "A3D5CA93-9DFE-4253-ACDC-63DBBBC52CB1",
            "service_uuid": "D7CB5D20-F47C-49DA-834E-EC1326696827",
            "service_notes": "Remind me project",
            "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "stamp_created": 1584633510,
            "stamp_created_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "stamp_updated": 1584633510,
            "stamp_updated_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "attachments": {
                "data": []
            }
        },
        {
            "note_uuid": "98F10B83-23A1-49AA-B2FE-FF32C8762EE7",
            "service_uuid": "D7CB5D20-F47C-49DA-834E-EC1326696827",
            "service_notes": "Remind me project",
            "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "stamp_created": 1584633634,
            "stamp_created_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "stamp_updated": 1584633634,
            "stamp_updated_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "attachments": {
                "data": [
                    {
                        "attachment_url": "http:\/\/localhost:8000\/office\/soundblock\/service\/notes",
                        "stamp_created": 1584633634,
                        "stamp_created_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        },
                        "stamp_updated": 1584633634,
                        "stamp_updated_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        }
                    }
                ]
            }
        },
        {
            "note_uuid": "EF75257C-981D-48BD-ABD3-C28CD37A3585",
            "service_uuid": "D7CB5D20-F47C-49DA-834E-EC1326696827",
            "service_notes": "Remind me project",
            "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "stamp_created": 1584634332,
            "stamp_created_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "stamp_updated": 1584634332,
            "stamp_updated_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "attachments": {
                "data": [
                    {
                        "attachment_url": "http:\/\/localhost:8000\/office\/soundblock\/service\/notes",
                        "stamp_created": 1584634332,
                        "stamp_created_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        },
                        "stamp_updated": 1584634332,
                        "stamp_updated_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        }
                    }
                ]
            }
        },
        {
            "note_uuid": "9DBF1895-99B1-4C82-B28E-403AE6BA4256",
            "service_uuid": "D7CB5D20-F47C-49DA-834E-EC1326696827",
            "service_notes": "Remind me project",
            "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "stamp_created": 1584634344,
            "stamp_created_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "stamp_updated": 1584634344,
            "stamp_updated_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "attachments": {
                "data": [
                    {
                        "attachment_url": "http:\/\/localhost:8000\/office\/soundblock\/service\/notes",
                        "stamp_created": 1584634344,
                        "stamp_created_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        },
                        "stamp_updated": 1584634344,
                        "stamp_updated_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        }
                    }
                ]
            }
        },
        {
            "note_uuid": "D361204C-E5B6-451E-8B2A-87CD6D3819EE",
            "service_uuid": "D7CB5D20-F47C-49DA-834E-EC1326696827",
            "service_notes": "Remind me project",
            "user_uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
            "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
            "stamp_created": 1584634510,
            "stamp_created_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "stamp_updated": 1584634510,
            "stamp_updated_by": {
                "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "attachments": {
                "data": [
                    {
                        "attachment_url": "http:\/\/localhost:8000\/office\/soundblock\/service\/notes",
                        "stamp_created": 1584634510,
                        "stamp_created_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        },
                        "stamp_updated": 1584634510,
                        "stamp_updated_by": {
                            "uuid": "4B81297A-4511-4D61-888A-8283FAADB072",
                            "name_first": "Yurii",
                            "name_middle": "",
                            "name_last": "Kosiak"
                        }
                    }
                ]
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 6,
            "count": 6,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": [],
            "from": 1
        }
    }
}
```

### HTTP Request
`GET office/soundblock/serviceplan/notes`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `service` |  optional  | string required

<!-- END_128dd0ab6f6d26c8095568055739c704 -->

<!-- START_28ae21e3ea98150999174a0982508d18 -->
## office/soundblock/project/deployment/{deployment}/download
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/deployment/1/download"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "collection_uuid": "BF412EF1-F264-42F0-8BC7-1E303075B026",
        "project_uuid": "2EA45A7C-7119-4639-B268-EB181FA4F184",
        "collection_comment": null,
        "stamp_created": 1584419294,
        "stamp_created_by": {
            "uuid": "5FB51F97-F406-4F62-B7FA-27A4FFB0D8F7",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584419294,
        "stamp_updated_by": {
            "uuid": "5FB51F97-F406-4F62-B7FA-27A4FFB0D8F7",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "files": {
            "data": [
                {
                    "file_id": 35,
                    "file_uuid": "B1B0CFF2-48AC-411A-B050-36B97D56E546",
                    "file_name": ".DS_Store",
                    "file_path": "\/Other",
                    "file_title": "",
                    "file_category": "other",
                    "file_sortby": "\/Other\/.DS_Store",
                    "file_size": 6148,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 36,
                    "file_uuid": "012F1F76-90DF-47FD-A3FF-9029C6079194",
                    "file_name": "22.psd",
                    "file_path": "\/Merch",
                    "file_title": "22",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/22.psd",
                    "file_size": 1993972,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 37,
                    "file_uuid": "A8605B01-036E-414F-A506-33A244C7156B",
                    "file_name": "artwork.png",
                    "file_path": "\/Other",
                    "file_title": "artwork",
                    "file_category": "other",
                    "file_sortby": "\/Other\/artwork.png",
                    "file_size": 1518587,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 38,
                    "file_uuid": "5D1D092A-0B24-4755-941B-BBBE85782443",
                    "file_name": "back.mp4",
                    "file_path": "\/Video",
                    "file_title": "back",
                    "file_category": "video",
                    "file_sortby": "\/Video\/back.mp4",
                    "file_size": 5249454,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 39,
                    "file_uuid": "A65097E9-457E-4A08-9C16-C38A24DABE8F",
                    "file_name": "file-1.doc",
                    "file_path": "\/Other",
                    "file_title": "file-1",
                    "file_category": "other",
                    "file_sortby": "\/Other\/file-1.doc",
                    "file_size": 512000,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 40,
                    "file_uuid": "EDE99B4D-9A12-4372-8C76-0D2327DE3F42",
                    "file_name": "Files-2.doc",
                    "file_path": "\/Other",
                    "file_title": "Files-2",
                    "file_category": "other",
                    "file_sortby": "\/Other\/Files-2.doc",
                    "file_size": 1024000,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 41,
                    "file_uuid": "149B08B5-F086-406B-9E77-CC47445AE909",
                    "file_name": "files-4.docx",
                    "file_path": "\/Other",
                    "file_title": "files-4",
                    "file_category": "other",
                    "file_sortby": "\/Other\/files-4.docx",
                    "file_size": 1026736,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 42,
                    "file_uuid": "D7799CC4-774C-4FEC-9CBC-D5A8C2E68C38",
                    "file_name": "I'm Back.mp3",
                    "file_path": "\/Music",
                    "file_title": "I'm Back",
                    "file_category": "music",
                    "file_sortby": "\/Music\/I'm Back.mp3",
                    "file_size": 2113939,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 43,
                    "file_uuid": "8972F45E-CE45-4B2C-86EB-91AC47E65E3C",
                    "file_name": "marsahal.mp4",
                    "file_path": "\/Video",
                    "file_title": "marsahal",
                    "file_category": "video",
                    "file_sortby": "\/Video\/marsahal.mp4",
                    "file_size": 14209460,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 44,
                    "file_uuid": "BCC33EA1-82F7-4455-B2AE-204184B5FC03",
                    "file_name": "Marshal Mathers.mp3",
                    "file_path": "\/Music",
                    "file_title": "Marshal Mathers",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Marshal Mathers.mp3",
                    "file_size": 2113939,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 45,
                    "file_uuid": "5B169AA8-5DF0-489E-8495-421D412EE755",
                    "file_name": "Me!.psd",
                    "file_path": "\/Merch",
                    "file_title": "Me!",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Me!.psd",
                    "file_size": 1993972,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 46,
                    "file_uuid": "87916AAD-6AD4-4A3D-B6BC-56D8F8195721",
                    "file_name": "Panic.ai",
                    "file_path": "\/Merch",
                    "file_title": "Panic",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Panic.ai",
                    "file_size": 826458,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 47,
                    "file_uuid": "5FBA5785-18A8-4A75-8B6D-314546BE15D6",
                    "file_name": "sample.psd",
                    "file_path": "\/Merch",
                    "file_title": "sample",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/sample.psd",
                    "file_size": 2196530,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 48,
                    "file_uuid": "0DA9E1E6-79EF-4310-B172-5017AECDD252",
                    "file_name": "Shake_it_off.psd",
                    "file_path": "\/Merch",
                    "file_title": "Shake_it_off",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Shake_it_off.psd",
                    "file_size": 2196530,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 49,
                    "file_uuid": "FCC5128B-CB94-45E7-B420-891A51A68698",
                    "file_name": "Stan.mp3",
                    "file_path": "\/Music",
                    "file_title": "Stan",
                    "file_category": "music",
                    "file_sortby": "\/Music\/Stan.mp3",
                    "file_size": 2113939,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 50,
                    "file_uuid": "5409BDBF-E2AC-45CD-9861-B31C1EBAD8EC",
                    "file_name": "Style.psd",
                    "file_path": "\/Merch",
                    "file_title": "Style",
                    "file_category": "merch",
                    "file_sortby": "\/Merch\/Style.psd",
                    "file_size": 2196530,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 51,
                    "file_uuid": "D9FA3135-9FFC-4D17-AC41-33678D2F705C",
                    "file_name": "video1.mp4",
                    "file_path": "\/Video",
                    "file_title": "video1",
                    "file_category": "video",
                    "file_sortby": "\/Video\/video1.mp4",
                    "file_size": 31539436,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 52,
                    "file_uuid": "75443B49-BB81-4959-B9B0-F6574959CB70",
                    "file_name": "video2.mp4",
                    "file_path": "\/Video",
                    "file_title": "video2",
                    "file_category": "video",
                    "file_sortby": "\/Video\/video2.mp4",
                    "file_size": 25311565,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "file_id": 53,
                    "file_uuid": "1E1E17CF-C30F-42AC-8ACC-53D7C1E947BD",
                    "file_name": "video3.mp4",
                    "file_path": "\/Video",
                    "file_title": "video3",
                    "file_category": "video",
                    "file_sortby": "\/Video\/video3.mp4",
                    "file_size": 14209460,
                    "stamp_created": 1584419297,
                    "stamp_created_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584419297,
                    "stamp_updated_by": {
                        "uuid": "2FF6A118-3120-4F0C-97EF-9172693AF886",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            ]
        }
    }
}
```

### HTTP Request
`GET office/soundblock/project/deployment/{deployment}/download`


<!-- END_28ae21e3ea98150999174a0982508d18 -->

<!-- START_26948460087e44e9d1e2e9eab5a299d7 -->
## office/soundblock/project/notes
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/notes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project": "laborum",
    "user": "eaque",
    "project_notes": "eum",
    "attachment_url": "esse"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "note_uuid": "86D2A4C0-E862-4D44-B338-1079A8E4FE46",
        "project_uuid": "B16F174B-427C-4DC5-9493-C3DA4F664332",
        "project_notes": "Cusomer service is required!",
        "stamp_created": 1584505030,
        "stamp_created_by": {
            "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "stamp_updated": 1584505030,
        "stamp_updated_by": {
            "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
            "name_first": "Yurii",
            "name_middle": "",
            "name_last": "Kosiak"
        },
        "user": {
            "data": {
                "user_uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak",
                "stamp_created": 1584499160,
                "stamp_created_by": {
                    "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1584499160,
                "stamp_updated_by": {
                    "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "avatar": {
                    "data": {
                        "avatar_uuid": "B973B974-49A2-45B2-9916-541CC82D82F6",
                        "avatar_url": "http:\/\/test.api.arena.com\/storage\/default\/avatar.png",
                        "stamp_created": 1584499161,
                        "stamp_created_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        },
                        "stamp_updated": 1584499161,
                        "stamp_updated_by": {
                            "uuid": "86D99096-E527-4153-9E14-4AF60451A498",
                            "name_first": "Samuel",
                            "name_middle": "",
                            "name_last": "White"
                        }
                    }
                }
            }
        },
        "attachments": {
            "data": [
                {
                    "attachment_url": "https:\/\/lorempixel.com\/640\/480\/?66608",
                    "stamp_created": 1584505030,
                    "stamp_created_by": {
                        "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                        "name_first": "Yurii",
                        "name_middle": "",
                        "name_last": "Kosiak"
                    },
                    "stamp_updated": 1584505030,
                    "stamp_updated_by": {
                        "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                        "name_first": "Yurii",
                        "name_middle": "",
                        "name_last": "Kosiak"
                    }
                }
            ]
        }
    }
}
```

### HTTP Request
`POST office/soundblock/project/notes`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project` | string |  required  | 
        `user` | string |  optional  | optional
        `project_notes` | string |  required  | 
        `attachment_url` | url |  optional  | optional
    
<!-- END_26948460087e44e9d1e2e9eab5a299d7 -->

<!-- START_7102cf91c4f902f1235c16787d6a7395 -->
## office/soundblock/project/notes/upload
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/notes/upload"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/soundblock/project/notes/upload`


<!-- END_7102cf91c4f902f1235c16787d6a7395 -->

<!-- START_fc7f942dec8011513a10eaf313fd33e6 -->
## office/soundblock/projects/deployment
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/projects/deployment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "deployments": [
        {
            "platform": "vero",
            "collection": "autem"
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "deployment_uuid": "26D57437-0BF6-4FD2-8FB2-AFD78CA2448B",
            "deployment_status": [],
            "distribution": "All Territory",
            "stamp_created": 1584600654,
            "stamp_created_by": {
                "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "stamp_updated": 1584600654,
            "stamp_updated_by": {
                "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            }
        },
        {
            "deployment_uuid": "5C4237E9-5125-457B-BBFC-3C0B8D81E311",
            "deployment_status": [],
            "distribution": "All Territory",
            "stamp_created": 1584600654,
            "stamp_created_by": {
                "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "stamp_updated": 1584600654,
            "stamp_updated_by": {
                "uuid": "971269E3-EA93-4E58-B0F2-3191E3F9E5DB",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            }
        }
    ]
}
```

### HTTP Request
`POST office/soundblock/projects/deployment`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `deployments` | array |  required  | 
        `deployments.*.platform` | string |  required  | 
        `deployments.*.collection` | string |  required  | 
    
<!-- END_fc7f942dec8011513a10eaf313fd33e6 -->

<!-- START_f8e2c40ca260d80d5e2a238881a53bff -->
## office/soundblock/project
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/soundblock/project`


<!-- END_f8e2c40ca260d80d5e2a238881a53bff -->

<!-- START_fe814eae56720fc01c788a2927290c6a -->
## office/soundblock/project/file
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/file"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project": "recusandae",
    "files": "repellendus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/soundblock/project/file`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project` | uuid |  required  | Project UUID
        `files` | file |  required  | 
    
<!-- END_fe814eae56720fc01c788a2927290c6a -->

<!-- START_50b2c6d34b46be31ff6f357d6e68de88 -->
## office/soundblock/project/artwork
> Example request:

```javascript
const url = new URL(
    "arena.api/office/soundblock/project/artwork"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project": "magnam",
    "project_avatar": "mollitia"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/soundblock/project/artwork`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project` | string |  required  | 
        `project_avatar` | file |  required  | mimetype png
    
<!-- END_50b2c6d34b46be31ff6f357d6e68de88 -->

<!-- START_c7a0bcb3b0578eab9ea9074b4e5b92b5 -->
## office/structure
> Example request:

```javascript
const url = new URL(
    "arena.api/office/structure"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/structure`


<!-- END_c7a0bcb3b0578eab9ea9074b4e5b92b5 -->

<!-- START_723a706c4c1f3cf27bcd17fa77725a0c -->
## office/structure
> Example request:

```javascript
const url = new URL(
    "arena.api/office/structure"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/structure`


<!-- END_723a706c4c1f3cf27bcd17fa77725a0c -->

<!-- START_fbd2eb2281ee8ad8782cfef9ee6378ca -->
## office/structure/prefix/{prefix}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/structure/prefix/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/structure/prefix/{prefix}`


<!-- END_fbd2eb2281ee8ad8782cfef9ee6378ca -->

<!-- START_7529a9b89a72dd9ce343255a61ebbd20 -->
## office/structure/{structure}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/structure/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/structure/{structure}`


<!-- END_7529a9b89a72dd9ce343255a61ebbd20 -->

<!-- START_859d1289f844610054b2b7bf462aa9a3 -->
## office/invoice/all/invoices
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/all/invoices"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/invoice/all/invoices`


<!-- END_859d1289f844610054b2b7bf462aa9a3 -->

<!-- START_301df2b95bbb29aa0e19f85c8a21ce54 -->
## office/invoice/all/types
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/all/types"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/invoice/all/types`


<!-- END_301df2b95bbb29aa0e19f85c8a21ce54 -->

<!-- START_e114a1b8b640cb195d148e38779e5821 -->
## office/invoice/store
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/store"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/invoice/store`


<!-- END_e114a1b8b640cb195d148e38779e5821 -->

<!-- START_ec8d7afe8ee970a1b5978d925ed5dce6 -->
## office/invoice/type
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/type"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST office/invoice/type`


<!-- END_ec8d7afe8ee970a1b5978d925ed5dce6 -->

<!-- START_c6c1f4ac01ed43ed0fb33a7aebfbaaf0 -->
## office/invoice/type/{type}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/type/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/invoice/type/{type}`


<!-- END_c6c1f4ac01ed43ed0fb33a7aebfbaaf0 -->

<!-- START_acf5f586235601d10f9f303be25cef13 -->
## office/invoice/type/{type}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/invoice/type/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE office/invoice/type/{type}`


<!-- END_acf5f586235601d10f9f303be25cef13 -->

<!-- START_1137f7fd2649024cbf3c6dd02be2f022 -->
## office/type/rate/{type_rate}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/type/rate/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH office/type/rate/{type_rate}`


<!-- END_1137f7fd2649024cbf3c6dd02be2f022 -->

<!-- START_b729071693cd5150ae903afeea3d7f82 -->
## office/type/rate/{type_rate}
> Example request:

```javascript
const url = new URL(
    "arena.api/office/type/rate/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE office/type/rate/{type_rate}`


<!-- END_b729071693cd5150ae903afeea3d7f82 -->

<!-- START_3776259938bf48108c1250736d27859e -->
## office/bootloader
> Example request:

```javascript
const url = new URL(
    "arena.api/office/bootloader"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET office/bootloader`


<!-- END_3776259938bf48108c1250736d27859e -->

<!-- START_3bcedda78ae45ef5c0f4c97a4963b7a1 -->
## user
> Example request:

```javascript
const url = new URL(
    "arena.api/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "user_uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
        "name_first": "Lazar",
        "name_middle": "",
        "name_last": "Jankovic",
        "stamp_created": 1584179854,
        "stamp_created_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1584179854,
        "stamp_updated_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "emails": {
            "data": [
                {
                    "user_auth_email": "lazar@arena.com",
                    "stamp_created": 1584179854,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179854,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_email": 1584179854,
                    "stamp_email_by": {
                        "uuid": "7C619A2D-9BF6-4F6A-BE96-17285A354344",
                        "name_first": "jin",
                        "name_middle": "",
                        "name_last": "tai"
                    }
                }
            ]
        },
        "phones": {
            "data": [
                {
                    "phone_type": "Home",
                    "phone_number": "1-243-253-4885",
                    "flag_primary": 1,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            ]
        },
        "postals": {
            "data": [
                {
                    "postal_uuid": "A07B91E0-6792-425D-B164-FB357E8FA56E",
                    "postal_type": "Office",
                    "postal_street": "Meggie Mission",
                    "postal_city": "Port Myrl",
                    "postal_zipcode": "64410-8416",
                    "postal_country": "Cayman Islands",
                    "flag_primary": 1,
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            ]
        },
        "paypals": {
            "data": [
                {
                    "paypal": "CE4409EF-A7EA-4618-85DF-3E96B1C5F4AA",
                    "paypal_email": "kristoffer.dibbert@hotmail.com",
                    "flag_primary": 1,
                    "stamp_created": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                },
                {
                    "paypal": "17FA9EBD-43DB-4C44-B9D4-900647A2DDFB",
                    "paypal_email": "qborer@howell.biz",
                    "flag_primary": 0,
                    "stamp_created": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            ]
        },
        "bankings": {
            "data": [
                {
                    "bank_uuid": "CCF1BB47-0D71-46DF-8A36-038ED2FFCF84",
                    "bank_name": "Elwin Hessel",
                    "account_type": "Saving",
                    "account_number": "83777690",
                    "routing_number": "1234567890",
                    "flag_primary": 1,
                    "stamp_created": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            ]
        }
    }
}
```

### HTTP Request
`GET user`


<!-- END_3bcedda78ae45ef5c0f4c97a4963b7a1 -->

<!-- START_10c700a1a5173f595c341e34abcd27fb -->
## user/profile
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/profile`


<!-- END_10c700a1a5173f595c341e34abcd27fb -->

<!-- START_89d068ad6c0739822860b28b68fde28a -->
## user/profile/profile
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/profile/profile`


<!-- END_89d068ad6c0739822860b28b68fde28a -->

<!-- START_06f396756d37fa31df028c12fec0d640 -->
## user/profile/address
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/address"
);

let params = {
    "user": "omnis",
    "per_page": "11",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/profile/address`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | uuid optional User UUID
    `per_page` |  optional  | integer required Items per page

<!-- END_06f396756d37fa31df028c12fec0d640 -->

<!-- START_8676b39dcd8f147ad3b93372ed8fdcda -->
## user/profile/address
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "postal_type": "sapiente",
    "postal_street": "corrupti",
    "postal_city": "qui",
    "postal_zipcode": "qui",
    "postal_country": "hic"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST user/profile/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `postal_type` | string |  required  | postal_type: "Home", "Office", "Billing", "Other"
        `postal_street` | string |  required  | string
        `postal_city` | string |  required  | string
        `postal_zipcode` | string |  required  | string
        `postal_country` | string |  required  | string
    
<!-- END_8676b39dcd8f147ad3b93372ed8fdcda -->

<!-- START_628bc55f61926ded003c483d5e3f97ff -->
## user/profile/address
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "postal": "rem",
    "postal_type": "aut",
    "postal_street": "rerum",
    "postal_city": "vero",
    "postal_zipcode": "quae",
    "postal_country": "modi",
    "flag_primary": true,
    "user": "laboriosam"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/profile/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `postal` | required |  optional  | Postal UUID
        `postal_type` | string |  optional  | optional The postal type
        `postal_street` | string |  optional  | optional
        `postal_city` | string |  optional  | optional
        `postal_zipcode` | string |  optional  | optional
        `postal_country` | string |  optional  | optional
        `flag_primary` | boolean |  optional  | optional
        `user` | uuid |  optional  | optional User UUID
    
<!-- END_628bc55f61926ded003c483d5e3f97ff -->

<!-- START_a032e081fe95a2e6691f29739375d5bb -->
## user/profile/address
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/address"
);

let params = {
    "postal": "impedit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": null,
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`DELETE user/profile/address`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `postal` |  optional  | string required

<!-- END_a032e081fe95a2e6691f29739375d5bb -->

<!-- START_a0968bf4f4297e521cf745088b1ceae7 -->
## user/profile/email
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/email"
);

let params = {
    "per_page": "4",
    "user": "voluptatem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/profile/email`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `per_page` |  optional  | integer required Items per page
    `user` |  optional  | uuid optional User UUID required if the app is office

<!-- END_a0968bf4f4297e521cf745088b1ceae7 -->

<!-- START_7beab3ed060667f91bd22b78092aa62d -->
## user/profile/email
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_auth_email": "error",
    "user": "quidem"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "user_auth_email": "ron@arena.com",
        "stamp_created": 1584292000,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Lazar",
            "name_middle": "",
            "name_last": "Jankovic"
        },
        "stamp_updated": 1584292000,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Lazar",
            "name_middle": "",
            "name_last": "Jankovic"
        },
        "stamp_email": null,
        "stamp_email_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Lazar",
            "name_middle": "",
            "name_last": "Jankovic"
        }
    }
}
```
> Example response (417):

```json
{
    "response": {
        "error": "Can not finish your query request!",
        "exception": "Illuminate\\Database\\QueryException",
        "message": "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '5-ron@arena.com' for key 'uidx_user-id_user-auth-email' (SQL: insert into `users_emails` (`row_uuid`, `user_id`, `user_uuid`, `user_auth_email`, `stamp_created`, `stamp_updated`, `stamp_created_by`, `stamp_updated_by`, `stamp_updated_at`, `stamp_created_at`) values (5BCCCC85-7401-4044-B2ED-912C044BBAAF, 5, 28F0270E-9906-4712-90F2-1236CEFA2958, ron@arena.com, 1584292025, 1584292025, 5, 5, 2020-03-15 17:07:05, 2020-03-15 17:07:05))"
    },
    "status": {
        "app": "Arena.API",
        "code": 422,
        "message": ""
    }
}
```

### HTTP Request
`POST user/profile/email`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user_auth_email` | email |  required  | 
        `user` | string |  required  | 
    
<!-- END_7beab3ed060667f91bd22b78092aa62d -->

<!-- START_fffd3ecd812d42f42c70097af842a784 -->
## user/profile/email
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "old_user_auth_email": "vero",
    "user_auth_email": "dolor",
    "flag_primary": true,
    "user": "quis"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/profile/email`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `old_user_auth_email` | email |  required  | The old email
        `user_auth_email` | email |  required  | The email
        `flag_primary` | boolean |  optional  | optional
        `user` | uuid |  optional  | optional User UUID
    
<!-- END_fffd3ecd812d42f42c70097af842a784 -->

<!-- START_3548b9d4e942d7aa4f206c9ef311e899 -->
## user/profile/email
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/email"
);

let params = {
    "user_auth_email": "molestiae",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": null,
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`DELETE user/profile/email`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user_auth_email` |  optional  | email required

<!-- END_3548b9d4e942d7aa4f206c9ef311e899 -->

<!-- START_e15e782af848bc50161de150d71a6360 -->
## user/profile/phone
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/phone"
);

let params = {
    "user": "hic",
    "per_page": "4",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/profile/phone`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | uuid optional User UUID
    `per_page` |  optional  | integer required Items per page

<!-- END_e15e782af848bc50161de150d71a6360 -->

<!-- START_1e25eac67ad3fc3083547d617770598f -->
## user/profile/phone
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/phone"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "phone_type": "totam",
    "phone_number": "ducimus",
    "flag_primary": true,
    "user": "repellendus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "phone_type": "Home",
        "phone_number": "202-555-0109",
        "flag_primary": true,
        "stamp_created": 1584290577,
        "stamp_created_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Lazar",
            "name_middle": "",
            "name_last": "Jankovic"
        },
        "stamp_updated": 1584290577,
        "stamp_updated_by": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Lazar",
            "name_middle": "",
            "name_last": "Jankovic"
        }
    }
}
```
> Example response (417):

```json
{
    "response": {
        "error": "Can not finish your query request!",
        "exception": "Illuminate\\Database\\QueryException",
        "message": "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '5-202-555-0109' for key 'uidx_user-id_phone-number' (SQL: insert into `users_contact_phones` (`row_uuid`, `user_id`, `user_uuid`, `phone_type`, `phone_number`, `flag_primary`, `stamp_created`, `stamp_updated`, `stamp_created_by`, `stamp_updated_by`, `stamp_updated_at`, `stamp_created_at`) values (03BBBAC3-3E7A-495F-AB3B-737249088C64, 5, 28F0270E-9906-4712-90F2-1236CEFA2958, Home, 202-555-0109, 1, 1584290624, 1584290624, 5, 5, 2020-03-15 16:43:44, 2020-03-15 16:43:44))"
    },
    "status": {
        "app": "Arena.API",
        "code": 422,
        "message": ""
    }
}
```

### HTTP Request
`POST user/profile/phone`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `phone_type` | string |  required  | 
        `phone_number` | phone |  required  | 
        `flag_primary` | boolean |  optional  | optional
        `user` | string |  optional  | optional The uuid of user
    
<!-- END_1e25eac67ad3fc3083547d617770598f -->

<!-- START_a0768368b4f15723beaaa1640f24b746 -->
## user/profile/phone
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/phone"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "magnam",
    "old_phone_number": "animi",
    "flag_primary": false
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/profile/phone`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | uuid |  optional  | optional User UUID
        `old_phone_number` | string |  required  | 
        `flag_primary` | boolean |  optional  | optional Is primary or not
    
<!-- END_a0768368b4f15723beaaa1640f24b746 -->

<!-- START_588cf38bc74b3ae8ec67b1bc53025f37 -->
## user/profile/phone
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/phone"
);

let params = {
    "phone_number": "inventore",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": null,
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`DELETE user/profile/phone`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `phone_number` |  optional  | numeric required

<!-- END_588cf38bc74b3ae8ec67b1bc53025f37 -->

<!-- START_0d0e157cf55ac224beca63cc385cf55a -->
## user/profile/bank
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/bank"
);

let params = {
    "user": "autem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/profile/bank`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | uuid optional User UUID

<!-- END_0d0e157cf55ac224beca63cc385cf55a -->

<!-- START_b8e25e861cdd3ed259078b0ca85627c5 -->
## user/profile/bank
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/bank"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "bank_name": "sunt",
    "account_type": "iste",
    "account_number": "veritatis",
    "routing_number": "qui"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "bank_uuid": "073EEAE1-5057-4DC4-A8C7-7B1657E91578",
        "bank_name": "China People Bank",
        "account_type": "Checking",
        "account_number": "123456",
        "routing_number": "123456",
        "flag_primary": false,
        "stamp_created": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`POST user/profile/bank`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `bank_name` | string |  required  | 
        `account_type` | string |  required  | 
        `account_number` | numeric |  required  | 
        `routing_number` | string |  required  | 
    
<!-- END_b8e25e861cdd3ed259078b0ca85627c5 -->

<!-- START_1fce55aae18c775c4b37f887724967fa -->
## user/profile/bank
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/bank"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "bank": "commodi",
    "bank_name": "dolorem",
    "account_type": "voluptatem",
    "account_number": "vero",
    "routing_number": "aliquid",
    "flag_primary": false,
    "user": "vel"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/profile/bank`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `bank` | uuid |  required  | Bank UUID
        `bank_name` | string |  optional  | optional The bank name
        `account_type` | string |  optional  | optional The account type
        `account_number` | digits |  optional  | optional The account number(1 to 25 digits)
        `routing_number` | digits |  optional  | optional The routing number(9 digits)
        `flag_primary` | boolean |  optional  | optional
        `user` | uuid |  optional  | optional User UUID
    
<!-- END_1fce55aae18c775c4b37f887724967fa -->

<!-- START_e8887fc9e4f912cf8ab1844d040fe824 -->
## user/profile/bank
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/bank"
);

let params = {
    "bank": "dolorem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": null,
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`DELETE user/profile/bank`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `bank` |  optional  | string required

<!-- END_e8887fc9e4f912cf8ab1844d040fe824 -->

<!-- START_e631f93dac6efac9c0869d0a0d906b6f -->
## user/profile/paypal
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/paypal"
);

let params = {
    "user": "enim",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/profile/paypal`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | uuid optional User UUID required if the app is office

<!-- END_e631f93dac6efac9c0869d0a0d906b6f -->

<!-- START_bd9039afb64634d5116baf642d44f02a -->
## user/profile/paypal
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/paypal"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "paypal": "sit",
    "paypal_email": "et",
    "flag_primary": false,
    "user": "iste"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/profile/paypal`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `paypal` | uuid |  required  | Paypal UUID
        `paypal_email` | email |  required  | The paypal email
        `flag_primary` | boolean |  optional  | optional
        `user` | uuid |  optional  | optional User UUID required if the app is office
    
<!-- END_bd9039afb64634d5116baf642d44f02a -->

<!-- START_d27c1ed6fd996f5b931b5dee7e7d043a -->
## user/profile/paypal
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/paypal"
);

let params = {
    "paypal": "corrupti",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": null,
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`DELETE user/profile/paypal`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paypal` |  optional  | string required

<!-- END_d27c1ed6fd996f5b931b5dee7e7d043a -->

<!-- START_fe27aa881439307861f498087354fe6c -->
## user/profile/payment/primary
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/payment/primary"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "veniam",
    "bank": "qui",
    "paypal": "voluptatem",
    "flag_primary": true
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "bank_uuid": "073EEAE1-5057-4DC4-A8C7-7B1657E91578",
        "bank_name": "China People Bank",
        "account_type": "Checking",
        "account_number": "123456",
        "routing_number": "123456",
        "flag_primary": true,
        "stamp_created": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        },
        "stamp_updated": {
            "uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
            "name_first": "Jin",
            "name_middle": "",
            "name_last": "Tai"
        }
    }
}
```

### HTTP Request
`PATCH user/profile/payment/primary`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `type` | string |  required  | 
        `bank` | string |  optional  | optional
        `paypal` | string |  optional  | optional
        `flag_primary` | boolean |  required  | 
    
<!-- END_fe27aa881439307861f498087354fe6c -->

<!-- START_d1c4eb7448ab0b700c7b3d73c3e24f55 -->
## user/profile/name
> Example request:

```javascript
const url = new URL(
    "arena.api/user/profile/name"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user": "illo",
    "name_first": "consectetur",
    "name_middle": "quasi",
    "name_last": "officia"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH user/profile/name`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user` | uuid |  optional  | optional USER UUID
        `name_first` | string |  required  | 
        `name_middle` | string |  optional  | optional
        `name_last` | string |  required  | 
    
<!-- END_d1c4eb7448ab0b700c7b3d73c3e24f55 -->

<!-- START_02fab76bbdc87094b1e37d002b07de6a -->
## user/notes
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notes"
);

let params = {
    "user": "minus",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET user/notes`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `user` |  optional  | uuid optional User UUID

<!-- END_02fab76bbdc87094b1e37d002b07de6a -->

<!-- START_b8a291dd841b504579f9663f8d57e2ac -->
## user/notes
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_notes": "inventore",
    "files": [
        "aut"
    ],
    "user": "soluta"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST user/notes`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user_notes` | string |  required  | 
        `files` | array |  required  | 
        `files.*` | file |  required  | 
        `user` | uuid |  optional  | optional User UUID required if the app is office
    
<!-- END_b8a291dd841b504579f9663f8d57e2ac -->

<!-- START_fc1d313002bdb897633a814add03565c -->
## user/notes
> Example request:

```javascript
const url = new URL(
    "arena.api/user/notes"
);

let params = {
    "note": "laboriosam",
    "user": "delectus",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE user/notes`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `note` |  optional  | uuid User Note UUID
    `user` |  optional  | uuid optional User UUID required if the app is office

<!-- END_fc1d313002bdb897633a814add03565c -->

<!-- START_5388fb1595a18739a1d00fec89d7869b -->
## soundblock/bootloader
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/bootloader"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": {
        "user": {
            "data": {
                "user_uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                "name_first": "Yurii",
                "name_middle": "",
                "name_last": "Kosiak"
            },
            "emails": [
                {
                    "user_auth_email": "ykosiak@arena.com"
                }
            ],
            "avatar": null
        },
        "services": [
            [
                {
                    "service": {
                        "service_uuid": "7BC828D1-B645-4A5E-8023-9795D69D335B",
                        "user_uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                        "service_name": "Service Name 3"
                    },
                    "permissions": [
                        {
                            "permission_uuid": "98D1E7DF-2E16-4EAD-B1CA-56A50DB4AD86",
                            "permission_name": "App.Soundblock.Service.Project.Create",
                            "permission_memo": "App.Soundblock.Service.Project.Create",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "92103616-D7F6-42BC-89DB-22B93621F1DD",
                            "permission_name": "App.Soundblock.Service.Project.Deploy",
                            "permission_memo": "App.Soundblock.Service.Project.Deploy",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "9069704F-B0FB-45F0-BDEB-FACA2E2B446B",
                            "permission_name": "App.Soundblock.Service.Report.Payments",
                            "permission_memo": "App.Soundblock.Service.Report.Payments",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "6E655241-68CC-421D-B540-EF0CE238CB40",
                            "permission_name": "App.Soundblock.Service.Storage.Simple",
                            "permission_memo": "App.Soundblock.Service.Storage.Simple",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "174D6E70-A524-412D-84DE-529F7CBBD28A",
                            "permission_name": "App.Soundblock.Service.Storage.Smart",
                            "permission_memo": "App.Soundblock.Service.Storage.Smart",
                            "flag_critical": 1
                        }
                    ]
                },
                {
                    "service": {
                        "service_uuid": "EC44339E-436E-4E2D-8310-0D92B683326C",
                        "user_uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "service_name": "Service Name 1"
                    },
                    "permissions": [
                        {
                            "permission_uuid": "98D1E7DF-2E16-4EAD-B1CA-56A50DB4AD86",
                            "permission_name": "App.Soundblock.Service.Project.Create",
                            "permission_memo": "App.Soundblock.Service.Project.Create",
                            "flag_critical": 1
                        }
                    ]
                },
                {
                    "service": {
                        "service_uuid": "7FBADC96-E9D1-4C9D-BB7C-13CC1C84D664",
                        "user_uuid": "4C6AAD53-70BA-470A-A854-0F88DBDC9E2E",
                        "service_name": "Service Name 2"
                    },
                    "permissions": [
                        {
                            "permission_uuid": "98D1E7DF-2E16-4EAD-B1CA-56A50DB4AD86",
                            "permission_name": "App.Soundblock.Service.Project.Create",
                            "permission_memo": "App.Soundblock.Service.Project.Create",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "92103616-D7F6-42BC-89DB-22B93621F1DD",
                            "permission_name": "App.Soundblock.Service.Project.Deploy",
                            "permission_memo": "App.Soundblock.Service.Project.Deploy",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "9069704F-B0FB-45F0-BDEB-FACA2E2B446B",
                            "permission_name": "App.Soundblock.Service.Report.Payments",
                            "permission_memo": "App.Soundblock.Service.Report.Payments",
                            "flag_critical": 1
                        }
                    ]
                },
                {
                    "service": {
                        "service_uuid": "37C8694E-0E7E-4C8D-A050-8B4DDB5EA875",
                        "user_uuid": "28F0270E-9906-4712-90F2-1236CEFA2958",
                        "service_name": "Service Name 5"
                    },
                    "permissions": [
                        {
                            "permission_uuid": "98D1E7DF-2E16-4EAD-B1CA-56A50DB4AD86",
                            "permission_name": "App.Soundblock.Service.Project.Create",
                            "permission_memo": "App.Soundblock.Service.Project.Create",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "6E655241-68CC-421D-B540-EF0CE238CB40",
                            "permission_name": "App.Soundblock.Service.Storage.Simple",
                            "permission_memo": "App.Soundblock.Service.Storage.Simple",
                            "flag_critical": 1
                        },
                        {
                            "permission_uuid": "174D6E70-A524-412D-84DE-529F7CBBD28A",
                            "permission_name": "App.Soundblock.Service.Storage.Smart",
                            "permission_memo": "App.Soundblock.Service.Storage.Smart",
                            "flag_critical": 1
                        }
                    ]
                }
            ]
        ]
    },
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`GET soundblock/bootloader`


<!-- END_5388fb1595a18739a1d00fec89d7869b -->

<!-- START_96149e9f25b45a14cb3b2f2a5b70d20d -->
## soundblock/noteable
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/noteable"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/noteable`


<!-- END_96149e9f25b45a14cb3b2f2a5b70d20d -->

<!-- START_3df0165679bea60eb3ba525a298879d7 -->
## soundblock/events
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/events"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/events`


<!-- END_3df0165679bea60eb3ba525a298879d7 -->

<!-- START_1bd748998086853c20945b355abaeca8 -->
## soundblock/event/{event}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/event/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/event/{event}`


<!-- END_1bd748998086853c20945b355abaeca8 -->

<!-- START_12b0d4cd6834be881128986356352e4a -->
## soundblock/drafts
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/drafts"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "draft_uuid": "208D89ED-D15A-468B-A9D3-A26C2DF5886D",
            "draft_json": {
                "project": {
                    "project_title": "The project4 for a draft",
                    "project_type": "Album",
                    "project_date": "2020-03-14",
                    "project_file": true,
                    "project_avatar": ""
                },
                "payment": {
                    "members": [
                        {
                            "name": "Jin Tai",
                            "email": "jintai@arena.com",
                            "role": "Band Member",
                            "Payout": 20
                        },
                        {
                            "name": "Samuel White",
                            "email": "swhite@arena.com",
                            "role": "Lawyer",
                            "Payout": 80
                        }
                    ],
                    "contract": {
                        "payment_message": "Custom Payment Message",
                        "name": "Rocky1",
                        "email": "rocky1@gmail.com",
                        "phone": "13833798"
                    }
                }
            },
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "service": {
                "data": {
                    "service_uuid": "F180F725-7D8A-45D4-9B4D-0FF8630666E4",
                    "service_name": "Service Name 4",
                    "stamp_created": 1584179854,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179854,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        }
    ]
}
```

### HTTP Request
`GET soundblock/drafts`


<!-- END_12b0d4cd6834be881128986356352e4a -->

<!-- START_78ae79537656d040f01d20b75528500b -->
## soundblock/draft
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/draft"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "service": "atque",
    "step": "exercitationem",
    "draft": "voluptatum",
    "project_title": "ducimus",
    "project_type": "sapiente",
    "project_date": "sequi",
    "project_avatar": "voluptas",
    "files": "quis",
    "tracks": [
        {
            "track_number": 3,
            "file": "architecto"
        }
    ],
    "members": [
        {
            "user_name": "dolores",
            "user_auth_email": "molestiae",
            "role": "error",
            "payout": 13
        }
    ],
    "contract_payment_message": "hic",
    "contract_name": "explicabo",
    "contract_email": "nemo",
    "contract_phone": "quas"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/draft`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `service` | string |  required  | 
        `step` | string |  required  | 
        `draft` | string |  required  | 
        `project_title` | string |  required  | 
        `project_type` | string |  required  | 
        `project_date` | date |  required  | 
        `project_avatar` | url |  required  | 
        `files` | file |  optional  | optional mimetype zip
        `tracks` | array |  optional  | optional
        `tracks.*.track_number` | integer |  required  | 
        `tracks.*.file` | string |  required  | 
        `members` | array |  optional  | 
        `members.*.user_name` | string |  optional  | nullable
        `members.*.user_auth_email` | email |  optional  | nullable
        `members.*.role` | string |  optional  | nullable
        `members.*.payout` | integer |  optional  | nullable
        `contract_payment_message` | string |  optional  | nullable
        `contract_name` | string |  optional  | nullable
        `contract_email` | string |  optional  | nullable
        `contract_phone` | string |  optional  | nullable
    
<!-- END_78ae79537656d040f01d20b75528500b -->

<!-- START_41dd96e9067f43951fb81f1fadfad5f3 -->
## soundblock/projects
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/projects"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "project_uuid": "E791A9D6-11AA-4129-8EAC-45A1F0D9422A",
            "project_title": "All Mirrors",
            "project_avatar": "http:\/\/test.api.arena.com\/storage\/default\/artwork.png",
            "project_type": "EP",
            "project_date": "2020-03-14",
            "project_upc": "615372079X",
            "stamp_created": 1584179855,
            "stamp_created_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "stamp_updated": 1584179855,
            "stamp_updated_by": {
                "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                "name_first": "Samuel",
                "name_middle": "",
                "name_last": "White"
            },
            "service": {
                "data": {
                    "service_uuid": "F180F725-7D8A-45D4-9B4D-0FF8630666E4",
                    "service_name": "Service Name 4",
                    "stamp_created": 1584179854,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179854,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            },
            "collections": {
                "data": {
                    "collection_uuid": "943926A2-5C95-4F80-8F58-4DE4D5191B8F",
                    "project_uuid": "E791A9D6-11AA-4129-8EAC-45A1F0D9422A",
                    "collection_comment": "Candida Kuhic",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            }
        }
    ],
    "meta": {
        "pages": {
            "total": 1,
            "count": 1,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": [],
            "from": 1
        }
    }
}
```

### HTTP Request
`GET soundblock/projects`


<!-- END_41dd96e9067f43951fb81f1fadfad5f3 -->

<!-- START_e49edb60f34f0fd59c7c96a2f8965abe -->
## soundblock/project/{project}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/1"
);

let params = {
    "project": "quidem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
        "project_title": "Remind me Tomorrow",
        "project_avatar": "http:\/\/test.api.arena.com\/storage\/default\/artwork.png",
        "project_type": "Album",
        "project_date": "2020-03-14",
        "project_upc": "3143592648",
        "stamp_created": 1584179855,
        "stamp_created_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "stamp_updated": 1584179855,
        "stamp_updated_by": {
            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
            "name_first": "Samuel",
            "name_middle": "",
            "name_last": "White"
        },
        "service": {
            "data": {
                "service_uuid": "7BC828D1-B645-4A5E-8023-9795D69D335B",
                "service_name": "Service Name 3",
                "stamp_created": 1584179854,
                "stamp_created_by": {
                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                },
                "stamp_updated": 1584179854,
                "stamp_updated_by": {
                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                    "name_first": "Samuel",
                    "name_middle": "",
                    "name_last": "White"
                }
            }
        },
        "collections": {
            "data": [
                {
                    "collection_uuid": "C7B547E1-008D-4A33-A0C0-6C0DBD544A25",
                    "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
                    "collection_comment": "Calista Runolfsson",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "musics": {
                        "data": [
                            {
                                "file_track": 1,
                                "file_duration": 238,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 24,
                                "file_uuid": "57C1E8AE-8E99-45BB-A84D-F8D61F968D3E",
                                "file_name": "Lose you to love me.mp3",
                                "file_path": "\/Music",
                                "file_title": "Lose You To Love Me",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Lose you to love me.mp3",
                                "file_size": 126504
                            },
                            {
                                "file_track": 1,
                                "file_duration": 297,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 3,
                                "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                                "file_name": "I'm Back.mp3",
                                "file_path": "\/Music",
                                "file_title": "I'm Back",
                                "file_category": "music",
                                "file_sortby": "\/Music\/I'm Back.mp3",
                                "file_size": 41774
                            },
                            {
                                "file_track": 2,
                                "file_duration": 263,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 1,
                                "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "file_name": "Stan.mp3",
                                "file_path": "\/Music",
                                "file_title": "Stan",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Stan.mp3",
                                "file_size": 294084
                            },
                            {
                                "file_track": 2,
                                "file_duration": 275,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 22,
                                "file_uuid": "A280ED6C-76DA-4929-BD79-03C757A7EA9A",
                                "file_name": "Old Town Road.mp3",
                                "file_path": "\/Music",
                                "file_title": "Old Town Road",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Old Town Road.mp3",
                                "file_size": 320068
                            },
                            {
                                "file_track": 3,
                                "file_duration": 278,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 23,
                                "file_uuid": "350FE70C-92A9-48EC-8E0C-C21EDFC326C3",
                                "file_name": "Don't Start Now.mp3",
                                "file_path": "\/Music",
                                "file_title": "Don't Start Now",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Don't Start Now.mp3",
                                "file_size": 312204
                            },
                            {
                                "file_track": 3,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 2,
                                "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                "file_name": "Marshal Mathers.mp3",
                                "file_path": "\/Music",
                                "file_title": "Marshal",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Marshal Mathers.mp3",
                                "file_size": 270163
                            }
                        ]
                    },
                    "fileshistory": {
                        "data": [
                            {
                                "file_id": 10,
                                "file_uuid": "B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5",
                                "file_name": "Panic.ai",
                                "file_path": "\/Merch\/Panic",
                                "file_title": "Panic",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Panic\/Panic.ai",
                                "file_size": 224497,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5 )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "B0D2B3FE-CEFE-48AB-87F2-35F822B2E5F5",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 1,
                                "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "file_name": "Stan.mp3",
                                "file_path": "\/Music",
                                "file_title": "Stan",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Stan.mp3",
                                "file_size": 294084,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 683552A6-6315-4EA6-85C2-745A6511C22B )",
                                "file_track": 2,
                                "file_duration": 263,
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 15,
                                "file_uuid": "87D18889-B923-4F6F-9456-BCC7760052C1",
                                "file_name": "Style.psd",
                                "file_path": "\/Merch\/Taylor",
                                "file_title": "Style",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Taylor\/Style.psd",
                                "file_size": 42923,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 87D18889-B923-4F6F-9456-BCC7760052C1 )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "87D18889-B923-4F6F-9456-BCC7760052C1",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 6,
                                "file_uuid": "6F782D8B-F0F3-41CC-BD12-C1785AC3277C",
                                "file_name": "video2.mp4",
                                "file_path": "\/Video",
                                "file_title": "video2",
                                "file_category": "video",
                                "file_sortby": "\/Video\/video2.mp4",
                                "file_size": 296578,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 6F782D8B-F0F3-41CC-BD12-C1785AC3277C )",
                                "track_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "track": "Stan",
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "6F782D8B-F0F3-41CC-BD12-C1785AC3277C",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 20,
                                "file_uuid": "87F9A531-FC9F-40D0-B9E1-BE2577865ABD",
                                "file_name": "Files-2.doc",
                                "file_path": "\/Other\/Files",
                                "file_title": "Files-2",
                                "file_category": "other",
                                "file_sortby": "\/Other\/Files\/Files-2.doc",
                                "file_size": 452621,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 87F9A531-FC9F-40D0-B9E1-BE2577865ABD )",
                                "file_history": [
                                    {
                                        "file_uuid": "87F9A531-FC9F-40D0-B9E1-BE2577865ABD",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 11,
                                "file_uuid": "6A7F364A-BA16-4DDD-AC93-612F57E73C98",
                                "file_name": "22.psd",
                                "file_path": "\/Merch",
                                "file_title": "22",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/22.psd",
                                "file_size": 424907,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 6A7F364A-BA16-4DDD-AC93-612F57E73C98 )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "6A7F364A-BA16-4DDD-AC93-612F57E73C98",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 2,
                                "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                "file_name": "Marshal Mathers.mp3",
                                "file_path": "\/Music",
                                "file_title": "Marshal",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Marshal Mathers.mp3",
                                "file_size": 270163,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 992540C5-F9CA-420D-9327-7058232DF2B2 )",
                                "file_track": 3,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 16,
                                "file_uuid": "6267298C-BC14-456E-B3B5-E30407EF4A80",
                                "file_name": "Shake_it_off.ai",
                                "file_path": "\/Merch\/Taylor",
                                "file_title": "Shake_it_off",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Taylor\/Shake_it_off.ai",
                                "file_size": 415981,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 6267298C-BC14-456E-B3B5-E30407EF4A80 )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "6267298C-BC14-456E-B3B5-E30407EF4A80",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 7,
                                "file_uuid": "C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40",
                                "file_name": "video2.mp4",
                                "file_path": "\/Video",
                                "file_title": "video2",
                                "file_category": "video",
                                "file_sortby": "\/Video\/marshal.mp4",
                                "file_size": 195797,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40 )",
                                "track_uuid": "350FE70C-92A9-48EC-8E0C-C21EDFC326C3",
                                "track": "Don't Start Now",
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "C1D88A24-CFF1-4F03-AA45-EFAA53ADFA40",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 21,
                                "file_uuid": "C406184B-3FFA-4DFD-BEEE-EDADED0F075B",
                                "file_name": "files-4.docx",
                                "file_path": "\/Other",
                                "file_title": "files-4",
                                "file_category": "other",
                                "file_sortby": "\/Other\/files-4.docx",
                                "file_size": 213584,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( C406184B-3FFA-4DFD-BEEE-EDADED0F075B )",
                                "file_history": [
                                    {
                                        "file_uuid": "C406184B-3FFA-4DFD-BEEE-EDADED0F075B",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 12,
                                "file_uuid": "703A32B8-E17B-47C3-8669-ED4362F68434",
                                "file_name": "22.psd",
                                "file_path": "\/Merch\/Panic",
                                "file_title": null,
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Panic\/22.psd",
                                "file_size": 230392,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 703A32B8-E17B-47C3-8669-ED4362F68434 )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "703A32B8-E17B-47C3-8669-ED4362F68434",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 3,
                                "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                                "file_name": "I'm Back.mp3",
                                "file_path": "\/Music",
                                "file_title": "I'm Back",
                                "file_category": "music",
                                "file_sortby": "\/Music\/I'm Back.mp3",
                                "file_size": 41774,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E )",
                                "file_track": 1,
                                "file_duration": 297,
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 17,
                                "file_uuid": "C70F71CD-9091-40B6-A524-1EE9D93E46F5",
                                "file_name": "file-1.doc",
                                "file_path": "\/Other",
                                "file_title": "file-1",
                                "file_category": "other",
                                "file_sortby": "\/Other\/file-1.doc",
                                "file_size": 277047,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( C70F71CD-9091-40B6-A524-1EE9D93E46F5 )",
                                "file_history": [
                                    {
                                        "file_uuid": "C70F71CD-9091-40B6-A524-1EE9D93E46F5",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 8,
                                "file_uuid": "F10B49EE-D440-4129-A064-2297BE3EEDF4",
                                "file_name": "video3.mp4",
                                "file_path": "\/Video",
                                "file_title": "video3",
                                "file_category": "video",
                                "file_sortby": "\/Video\/video3.mp4",
                                "file_size": 143251,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( F10B49EE-D440-4129-A064-2297BE3EEDF4 )",
                                "track_uuid": "57C1E8AE-8E99-45BB-A84D-F8D61F968D3E",
                                "track": "Lose You To Love Me",
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "F10B49EE-D440-4129-A064-2297BE3EEDF4",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 13,
                                "file_uuid": "3DD9FB96-1711-467A-ABD5-75A2287EECEC",
                                "file_name": "Me!.psd",
                                "file_path": "\/Merch",
                                "file_title": "merch",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Me!.psd",
                                "file_size": 495901,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 3DD9FB96-1711-467A-ABD5-75A2287EECEC )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "3DD9FB96-1711-467A-ABD5-75A2287EECEC",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 4,
                                "file_uuid": "3C08F084-DD6C-45D4-8058-56194196602A",
                                "file_name": "back.mp4",
                                "file_path": "\/Video",
                                "file_title": "back",
                                "file_category": "video",
                                "file_sortby": "\/Video\/back.mp4",
                                "file_size": 107950,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 3C08F084-DD6C-45D4-8058-56194196602A )",
                                "track_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                "track": "Marshal",
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "3C08F084-DD6C-45D4-8058-56194196602A",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 18,
                                "file_uuid": "0D21E453-0ED9-4E18-8BBE-A454E97389C5",
                                "file_name": "file-1.doc",
                                "file_path": "\/Other\/Files",
                                "file_title": "file-1",
                                "file_category": "other",
                                "file_sortby": "\/Other\/Files\/file-1.doc",
                                "file_size": 257269,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 0D21E453-0ED9-4E18-8BBE-A454E97389C5 )",
                                "file_history": [
                                    {
                                        "file_uuid": "0D21E453-0ED9-4E18-8BBE-A454E97389C5",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 9,
                                "file_uuid": "4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A",
                                "file_name": "Panic.ai",
                                "file_path": "\/Merch",
                                "file_title": "Panic",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Panic.ai",
                                "file_size": 447387,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "4A44D9A8-E8EF-43C8-A961-C87DB2CC6A9A",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 14,
                                "file_uuid": "60FCCF9F-DA47-4473-940F-41D1B7844159",
                                "file_name": "Me!.psd",
                                "file_path": "\/Merch\/Taylor",
                                "file_title": "merch",
                                "file_category": "merch",
                                "file_sortby": "\/Merch\/Taylor\/Me!.psd",
                                "file_size": 318598,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 60FCCF9F-DA47-4473-940F-41D1B7844159 )",
                                "file_sku": "4225-776-3234",
                                "file_history": [
                                    {
                                        "file_uuid": "60FCCF9F-DA47-4473-940F-41D1B7844159",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 5,
                                "file_uuid": "D81267FD-B51E-489E-B0D2-19E6F09CBBA4",
                                "file_name": "video1.mp4",
                                "file_path": "\/Video",
                                "file_title": "video1",
                                "file_category": "video",
                                "file_sortby": "\/Video\/back.mp4",
                                "file_size": 228962,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( D81267FD-B51E-489E-B0D2-19E6F09CBBA4 )",
                                "track_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "track": "Everyone Like",
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "D81267FD-B51E-489E-B0D2-19E6F09CBBA4",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 19,
                                "file_uuid": "45283D97-3278-48DF-AA70-7AFAD9E77A0D",
                                "file_name": "Files-2.doc",
                                "file_path": "\/Other",
                                "file_title": "Files-2",
                                "file_category": "other",
                                "file_sortby": "\/Other\/Files-2.doc",
                                "file_size": 403355,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File( 45283D97-3278-48DF-AA70-7AFAD9E77A0D )",
                                "file_history": [
                                    {
                                        "file_uuid": "45283D97-3278-48DF-AA70-7AFAD9E77A0D",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                            "name_first": "Samuel",
                                            "name_middle": "",
                                            "name_last": "White"
                                        }
                                    }
                                ]
                            }
                        ]
                    },
                    "history": {
                        "data": {
                            "history_uuid": "723F3F79-4256-4698-A9B5-334399667287",
                            "history_category": "Multiple",
                            "history_size": 5783021,
                            "file_action": "Created",
                            "history_comment": "Music( CaapmTqpbcZGz5NB )",
                            "stamp_created": 1584179856,
                            "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                        }
                    }
                },
                {
                    "collection_uuid": "1F9AE105-D7FD-40B1-BC1F-1C978E8D4B96",
                    "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
                    "collection_comment": "**yurii",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "musics": {
                        "data": [
                            {
                                "file_track": 1,
                                "file_duration": 297,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 3,
                                "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                                "file_name": "I'm Back.mp3",
                                "file_path": "\/Music",
                                "file_title": "I'm Back",
                                "file_category": "music",
                                "file_sortby": "\/Music\/I'm Back.mp3",
                                "file_size": 41774
                            },
                            {
                                "file_track": 2,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 31,
                                "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                                "file_name": "special.mp3",
                                "file_path": "\/Music",
                                "file_title": "Everyone Like",
                                "file_category": "music",
                                "file_sortby": "\/Music\/special.mp3",
                                "file_size": 345095
                            },
                            {
                                "file_track": 2,
                                "file_duration": 263,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 1,
                                "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "file_name": "Stan.mp3",
                                "file_path": "\/Music",
                                "file_title": "Stan",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Stan.mp3",
                                "file_size": 294084
                            },
                            {
                                "file_track": 3,
                                "file_duration": 277,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 32,
                                "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "file_name": "special-1.mp3",
                                "file_path": "\/Music",
                                "file_title": "Everyone Like",
                                "file_category": "music",
                                "file_sortby": "\/Music\/sepcial-1.mp3",
                                "file_size": 335955
                            },
                            {
                                "file_track": 3,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 2,
                                "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                "file_name": "Marshal Mathers.mp3",
                                "file_path": "\/Music",
                                "file_title": "Marshal",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Marshal Mathers.mp3",
                                "file_size": 270163
                            }
                        ]
                    },
                    "fileshistory": {
                        "data": [
                            {
                                "file_id": 31,
                                "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                                "file_name": "special.mp3",
                                "file_path": "\/Music",
                                "file_title": "Everyone Like",
                                "file_category": "music",
                                "file_sortby": "\/Music\/special.mp3",
                                "file_size": 345095,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File ( 50F762AB-B76E-4743-8EB9-A13CB47FA33D ) Created",
                                "file_track": 2,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 32,
                                "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "file_name": "special-1.mp3",
                                "file_path": "\/Music",
                                "file_title": "Everyone Like",
                                "file_category": "music",
                                "file_sortby": "\/Music\/sepcial-1.mp3",
                                "file_size": 335955,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File ( 5A5774DA-8346-4ED8-A5F7-0C3C20C12643 ) Created",
                                "file_track": 3,
                                "file_duration": 277,
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                        "file_action": "Deleted",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        }
                                    },
                                    {
                                        "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        }
                                    }
                                ]
                            }
                        ]
                    },
                    "history": {
                        "data": {
                            "history_uuid": "25DD8DFE-2D2B-4DD8-9679-553B94903DF2",
                            "history_category": "Music",
                            "history_size": 681050,
                            "file_action": "Created",
                            "history_comment": "Music( vtQ4RpEYLoMcNS44 )",
                            "stamp_created": 1584179856,
                            "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                        }
                    }
                },
                {
                    "collection_uuid": "90F2F1A4-F296-43AC-ADBD-F8A4BF495C99",
                    "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
                    "collection_comment": "**yurii",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "musics": {
                        "data": [
                            {
                                "file_track": 1,
                                "file_duration": 297,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 3,
                                "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                                "file_name": "I'm Back.mp3",
                                "file_path": "\/Music",
                                "file_title": "I'm Back",
                                "file_category": "music",
                                "file_sortby": "\/Music\/I'm Back.mp3",
                                "file_size": 41774
                            },
                            {
                                "file_track": 2,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 31,
                                "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                                "file_name": "special.mp3",
                                "file_path": "\/Music",
                                "file_title": "Everyone Like",
                                "file_category": "music",
                                "file_sortby": "\/Music\/special.mp3",
                                "file_size": 345095
                            },
                            {
                                "file_track": 2,
                                "file_duration": 263,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 1,
                                "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "file_name": "Stan.mp3",
                                "file_path": "\/Music",
                                "file_title": "Stan",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Stan.mp3",
                                "file_size": 294084
                            },
                            {
                                "file_track": 3,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 2,
                                "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                "file_name": "Marshal Mathers.mp3",
                                "file_path": "\/Music",
                                "file_title": "Marshal",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Marshal Mathers.mp3",
                                "file_size": 270163
                            }
                        ]
                    },
                    "fileshistory": {
                        "data": [
                            {
                                "file_id": 32,
                                "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                "file_name": "special-1.mp3",
                                "file_path": "\/Music",
                                "file_title": "Everyone Like",
                                "file_category": "music",
                                "file_sortby": "\/Music\/sepcial-1.mp3",
                                "file_size": 335955,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Deleted",
                                "file_memo": "File ( 5A5774DA-8346-4ED8-A5F7-0C3C20C12643 ) Deleted",
                                "file_track": 3,
                                "file_duration": 277,
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                        "file_action": "Deleted",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        }
                                    },
                                    {
                                        "file_uuid": "5A5774DA-8346-4ED8-A5F7-0C3C20C12643",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        }
                                    }
                                ]
                            }
                        ]
                    },
                    "history": {
                        "data": {
                            "history_uuid": "2A0E23E7-A132-459F-AF63-1298B420FD0E",
                            "history_category": "Video",
                            "history_size": 335955,
                            "file_action": "Deleted",
                            "history_comment": "Video( WabHQDmXO96YwOsJ )",
                            "stamp_created": 1584179856,
                            "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                        }
                    }
                },
                {
                    "collection_uuid": "329AC445-0317-4A19-856C-40624BCD80A1",
                    "project_uuid": "1B150CD8-3F18-4E8C-8F63-FC6414F0A27E",
                    "collection_comment": "**yurii",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "musics": {
                        "data": [
                            {
                                "file_track": 1,
                                "file_duration": 297,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 3,
                                "file_uuid": "B0F3AAE4-016D-473E-9F5B-A7FEDCDB688E",
                                "file_name": "I'm Back.mp3",
                                "file_path": "\/Music",
                                "file_title": "I'm Back",
                                "file_category": "music",
                                "file_sortby": "\/Music\/I'm Back.mp3",
                                "file_size": 41774
                            },
                            {
                                "file_track": 2,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 31,
                                "file_uuid": "50F762AB-B76E-4743-8EB9-A13CB47FA33D",
                                "file_name": "special.mp3",
                                "file_path": "\/Music",
                                "file_title": "Everyone Like",
                                "file_category": "music",
                                "file_sortby": "\/Music\/special.mp3",
                                "file_size": 345095
                            },
                            {
                                "file_track": 2,
                                "file_duration": 263,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 1,
                                "file_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "file_name": "Stan.mp3",
                                "file_path": "\/Music",
                                "file_title": "Stan",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Stan.mp3",
                                "file_size": 294084
                            },
                            {
                                "file_track": 3,
                                "file_duration": 252,
                                "file_isrc": "NOX001212345",
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_id": 2,
                                "file_uuid": "992540C5-F9CA-420D-9327-7058232DF2B2",
                                "file_name": "Marshal Mathers.mp3",
                                "file_path": "\/Music",
                                "file_title": "Marshal",
                                "file_category": "music",
                                "file_sortby": "\/Music\/Marshal Mathers.mp3",
                                "file_size": 270163
                            }
                        ]
                    },
                    "fileshistory": {
                        "data": [
                            {
                                "file_id": 33,
                                "file_uuid": "1D869E35-C4BE-482D-9B7F-B4968ABF4750",
                                "file_name": "special-video.mp4",
                                "file_path": "\/Video",
                                "file_title": "Everyone Like this",
                                "file_category": "video",
                                "file_sortby": "\/Video\/special-video.mp4",
                                "file_size": 354531,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File ( 1D869E35-C4BE-482D-9B7F-B4968ABF4750 ) Created",
                                "track_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "track": "Stan",
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "1D869E35-C4BE-482D-9B7F-B4968ABF4750",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        }
                                    }
                                ]
                            },
                            {
                                "file_id": 34,
                                "file_uuid": "EFAC68DF-6468-4A28-A8B4-0EE2E03D0294",
                                "file_name": "special-image.ai",
                                "file_path": "\/Video",
                                "file_title": "Everyone Like this",
                                "file_category": "video",
                                "file_sortby": "\/Video\/special-video-1.mp4",
                                "file_size": 280579,
                                "stamp_created": 1584179856,
                                "stamp_created_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "stamp_updated": 1584179856,
                                "stamp_updated_by": {
                                    "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                                    "name_first": "Samuel",
                                    "name_middle": "",
                                    "name_last": "White"
                                },
                                "file_action": "Created",
                                "file_memo": "File ( EFAC68DF-6468-4A28-A8B4-0EE2E03D0294 ) Created",
                                "track_uuid": "683552A6-6315-4EA6-85C2-745A6511C22B",
                                "track": "Stan",
                                "file_isrc": "NOX001212345",
                                "file_history": [
                                    {
                                        "file_uuid": "EFAC68DF-6468-4A28-A8B4-0EE2E03D0294",
                                        "file_action": "Created",
                                        "stamp_created": 1584179856,
                                        "stamp_created_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        },
                                        "stamp_updated": 1584179856,
                                        "stamp_updated_by": {
                                            "uuid": "21B9D205-15C5-4447-B131-7BED04988830",
                                            "name_first": "Yurii",
                                            "name_middle": "",
                                            "name_last": "Kosiak"
                                        }
                                    }
                                ]
                            }
                        ]
                    },
                    "history": {
                        "data": {
                            "history_uuid": "844E1DF3-67D3-4A66-B295-1C6D1D58D945",
                            "history_category": "Multiple",
                            "history_size": 1325300,
                            "file_action": "Created",
                            "history_comment": "Multiple( ZSepHTqw9HsrXx31 )",
                            "stamp_created": 1584179856,
                            "stamp_created_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                            "stamp_updated": 1584179856,
                            "stamp_updated_by": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A"
                        }
                    }
                }
            ]
        },
        "deployments": {
            "data": [
                {
                    "deployment_uuid": "723A1EBB-803C-4DC4-BB87-ED4B795D5170",
                    "deployment_status": {
                        "deployment_status": "Pending",
                        "deployment_memo": "deployment_memo"
                    },
                    "distribution": "All Territory",
                    "stamp_created": 1584179856,
                    "stamp_created_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    },
                    "stamp_updated": 1584179856,
                    "stamp_updated_by": {
                        "uuid": "0D1FFFF5-93B3-4F6D-BB8D-42EA2778969A",
                        "name_first": "Samuel",
                        "name_middle": "",
                        "name_last": "White"
                    }
                }
            ]
        }
    }
}
```

### HTTP Request
`GET soundblock/project/{project}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `project` |  optional  | uuid required Project UUID

<!-- END_e49edb60f34f0fd59c7c96a2f8965abe -->

<!-- START_ea2f3f3d9d62a57224bbc696532edb12 -->
## soundblock/project
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project_title": "magnam",
    "project_type": "qui",
    "project_date": "in",
    "files": "non",
    "members": [
        {
            "user_name": "omnis",
            "user_auth_email": "corporis",
            "role": "labore",
            "payout": "et"
        }
    ],
    "contract_payment_message": "excepturi",
    "contract_name": "nihil",
    "contract_email": "officia",
    "contract_phone": "minima"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "project_uuid": "781EB5C4-4F5A-4708-8ED0-E33A151C24F3",
        "project_title": "Marshal Marther",
        "project_avatar": "http:\/\/test.api.arena.com\/storage\/soundblock\/service\/F180F725-7D8A-45D4-9B4D-0FF8630666E4\/projects\/781EB5C4-4F5A-4708-8ED0-E33A151C24F3\/artwork.png",
        "project_type": "Album",
        "project_date": "2020-10-10",
        "project_upc": null,
        "stamp_created": 1584319691,
        "stamp_created_by": {
            "uuid": "7C619A2D-9BF6-4F6A-BE96-17285A354344",
            "name_first": "jin",
            "name_middle": "",
            "name_last": "tai"
        },
        "stamp_updated": 1584319691,
        "stamp_updated_by": {
            "uuid": "7C619A2D-9BF6-4F6A-BE96-17285A354344",
            "name_first": "jin",
            "name_middle": "",
            "name_last": "tai"
        },
        "collections": {
            "data": []
        }
    }
}
```

### HTTP Request
`POST soundblock/project`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project_title` | string |  required  | the title of project.
        `project_type` | string |  required  | Album, Ep, etc
        `project_date` | date |  required  | (2020-01-01).
        `files` | file |  required  | mime zip
        `members` | array |  required  | 
        `members.*.user_name` | string |  required  | 
        `members.*.user_auth_email` | email |  required  | 
        `members.*.role` | string |  required  | 
        `members.*.payout` | string |  required  | 
        `contract_payment_message` | string |  required  | 
        `contract_name` | string |  required  | 
        `contract_email` | string |  required  | 
        `contract_phone` | numeric |  required  | 
    
<!-- END_ea2f3f3d9d62a57224bbc696532edb12 -->

<!-- START_094e11a41ed98a2184b0d47cd5a96313 -->
## soundblock/ping-zip
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/ping-zip"
);

let params = {
    "project": "quia",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/ping-zip`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `project` |  optional  | string required

<!-- END_094e11a41ed98a2184b0d47cd5a96313 -->

<!-- START_ffde90fcf0554604c233cc4d982f695c -->
## soundblock/project/file
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/file"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project": "voluptatem",
    "files": "nemo"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/file`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project` | uuid |  required  | Project UUID
        `files` | file |  required  | 
    
<!-- END_ffde90fcf0554604c233cc4d982f695c -->

<!-- START_c09cd65cdce9c3ee99f74de06afa5a6d -->
## soundblock/project/confirm
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/confirm"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/confirm`


<!-- END_c09cd65cdce9c3ee99f74de06afa5a6d -->

<!-- START_9af4801a995c17bee53baf5cfac32ecf -->
## soundblock/project/artwork
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/artwork"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "project": "perferendis",
    "project_avatar": "earum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/artwork`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `project` | string |  required  | 
        `project_avatar` | file |  required  | mimetype png
    
<!-- END_9af4801a995c17bee53baf5cfac32ecf -->

<!-- START_ba236676c929c197078bffd2a0091735 -->
## soundblock/project/draft/artwork
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/draft/artwork"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "service": "impedit",
    "draft": "velit",
    "project_avatar": "est"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "response": {
        "data": {
            "url": "http:\/\/test.api.arena.com\/storage\/soundblock\/service\/F180F725-7D8A-45D4-9B4D-0FF8630666E4\/projects\/drafts\/artworks\/F180F725-7D8A-45D4-9B4D-0FF8630666E4.png"
        }
    },
    "status": {
        "app": "Arena.API",
        "code": 200,
        "message": ""
    }
}
```

### HTTP Request
`POST soundblock/project/draft/artwork`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `service` | string |  required  | 
        `draft` | string |  optional  | nullable
        `project_avatar` | file |  required  | mimetype png
    
<!-- END_ba236676c929c197078bffd2a0091735 -->

<!-- START_3f21463b6db9b8e1a89a0cd42a4afbe9 -->
## soundblock/project/{project}/team
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/1/team"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/{project}/team`


<!-- END_3f21463b6db9b8e1a89a0cd42a4afbe9 -->

<!-- START_188877b30acc9c1b0810cfe4484cd6db -->
## soundblock/project/team
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/team"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST soundblock/project/team`


<!-- END_188877b30acc9c1b0810cfe4484cd6db -->

<!-- START_e15144f6784666b287890d7949f98507 -->
## soundblock/project/contract/{contract}/cancel
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/contract/1/cancel"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/project/contract/{contract}/cancel`


<!-- END_e15144f6784666b287890d7949f98507 -->

<!-- START_c167d66518832261d9bc336109f336dd -->
## soundblock/project/team/{team}
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/team/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/project/team/{team}`


<!-- END_c167d66518832261d9bc336109f336dd -->

<!-- START_278a6e53003927de25aeabb608f963c8 -->
## soundblock/project/team/{team}/user/{user}/permissions
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/team/1/user/1/permissions"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET soundblock/project/team/{team}/user/{user}/permissions`


<!-- END_278a6e53003927de25aeabb608f963c8 -->

<!-- START_7d188025617f4ef7b22d5e2111638e05 -->
## soundblock/project/team/{team}/user/{user}/permissions
> Example request:

```javascript
const url = new URL(
    "arena.api/soundblock/project/team/1/user/1/permissions"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH soundblock/project/team/{team}/user/{user}/permissions`


<!-- END_7d188025617f4ef7b22d5e2111638e05 -->

<!-- START_647bddcc9eb45a41c119be8a2443f16c -->
## apparel/categories
> Example request:

```javascript
const url = new URL(
    "arena.api/apparel/categories"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET apparel/categories`


<!-- END_647bddcc9eb45a41c119be8a2443f16c -->

<!-- START_1d118ae25414d8eb957cc5f331a440e3 -->
## apparel/category/{categoryUuid}
> Example request:

```javascript
const url = new URL(
    "arena.api/apparel/category/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET apparel/category/{categoryUuid}`


<!-- END_1d118ae25414d8eb957cc5f331a440e3 -->

<!-- START_2d286a516d4f47375049a48d63ef3b16 -->
## apparel/category/{categoryUuid}/attributes
> Example request:

```javascript
const url = new URL(
    "arena.api/apparel/category/1/attributes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET apparel/category/{categoryUuid}/attributes`


<!-- END_2d286a516d4f47375049a48d63ef3b16 -->

<!-- START_75f32c686b910dfa39283e29fd615a2f -->
## apparel/bootstrap
> Example request:

```javascript
const url = new URL(
    "arena.api/apparel/bootstrap"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET apparel/bootstrap`


<!-- END_75f32c686b910dfa39283e29fd615a2f -->

<!-- START_748455e30494ab5033e81a8709f8e8fc -->
## mail/send
> Example request:

```javascript
const url = new URL(
    "arena.api/mail/send"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET mail/send`


<!-- END_748455e30494ab5033e81a8709f8e8fc -->

<!-- START_37db388b089b2027a9d7b3d5cfbcc556 -->
## email/{email}/verify
> Example request:

```javascript
const url = new URL(
    "arena.api/email/1/verify"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST email/{email}/verify`


<!-- END_37db388b089b2027a9d7b3d5cfbcc556 -->

<!-- START_9b331e9f97c5216b0a6d626f45d8eecb -->
## invoice1
> Example request:

```javascript
const url = new URL(
    "arena.api/invoice1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET invoice1`


<!-- END_9b331e9f97c5216b0a6d626f45d8eecb -->

<!-- START_18236a8cf085de94a376ac7047e0ff91 -->
## coupon1
> Example request:

```javascript
const url = new URL(
    "arena.api/coupon1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET coupon1`


<!-- END_18236a8cf085de94a376ac7047e0ff91 -->

<!-- START_0569d690b86d02eff064e56748961adf -->
## invoice1-item
> Example request:

```javascript
const url = new URL(
    "arena.api/invoice1-item"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET invoice1-item`


<!-- END_0569d690b86d02eff064e56748961adf -->

<!-- START_6fb784cd637073a685395675ae1fb23d -->
## invoice1
> Example request:

```javascript
const url = new URL(
    "arena.api/invoice1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST invoice1`


<!-- END_6fb784cd637073a685395675ae1fb23d -->

<!-- START_2c21ccdea751680c8df1092c675cc52f -->
## job
> Example request:

```javascript
const url = new URL(
    "arena.api/job"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH job`


<!-- END_2c21ccdea751680c8df1092c675cc52f -->

<!-- START_8923568f112f8bb7480a51fecaa1fcbc -->
## job/{job}/status
> Example request:

```javascript
const url = new URL(
    "arena.api/job/1/status"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET job/{job}/status`


<!-- END_8923568f112f8bb7480a51fecaa1fcbc -->

<!-- START_102d5465898cb48a6265ec459acfebdc -->
## jobs/status
> Example request:

```javascript
const url = new URL(
    "arena.api/jobs/status"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET jobs/status`


<!-- END_102d5465898cb48a6265ec459acfebdc -->

<!-- START_f5f26892e3f3605a384c1378f3fbc116 -->
## invoices
> Example request:

```javascript
const url = new URL(
    "arena.api/invoices"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET invoices`


<!-- END_f5f26892e3f3605a384c1378f3fbc116 -->

<!-- START_64030476a80017cc2cca27780fd1fd29 -->
## invoice
> Example request:

```javascript
const url = new URL(
    "arena.api/invoice"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST invoice`


<!-- END_64030476a80017cc2cca27780fd1fd29 -->

<!-- START_4b75544a748dd414088cc72849fc65e4 -->
## invoice/types
> Example request:

```javascript
const url = new URL(
    "arena.api/invoice/types"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET invoice/types`


<!-- END_4b75544a748dd414088cc72849fc65e4 -->

<!-- START_af8c3f899fa88b6e63216a02522b6d1b -->
## status/ping
> Example request:

```javascript
const url = new URL(
    "arena.api/status/ping"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET status/ping`


<!-- END_af8c3f899fa88b6e63216a02522b6d1b -->

<!-- START_9f95fe9f4997b70c210244b927262470 -->
## status/data
> Example request:

```javascript
const url = new URL(
    "arena.api/status/data"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET status/data`


<!-- END_9f95fe9f4997b70c210244b927262470 -->

<!-- START_57d6f66158000cdc7af13829fd7d28b8 -->
## status/version
> Example request:

```javascript
const url = new URL(
    "arena.api/status/version"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET status/version`


<!-- END_57d6f66158000cdc7af13829fd7d28b8 -->

<!-- START_6de39c59f9be81b804ebb370766021b7 -->
## core/cart/item
> Example request:

```javascript
const url = new URL(
    "arena.api/core/cart/item"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/cart/item`


<!-- END_6de39c59f9be81b804ebb370766021b7 -->

<!-- START_9758df9c880c545a1b5204f1fe3fce79 -->
## core/cart/item/{item}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/cart/item/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE core/cart/item/{item}`


<!-- END_9758df9c880c545a1b5204f1fe3fce79 -->

<!-- START_2a011cb0dea30f91807272271bd92745 -->
## core/cart/items
> Example request:

```javascript
const url = new URL(
    "arena.api/core/cart/items"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/cart/items`


<!-- END_2a011cb0dea30f91807272271bd92745 -->

<!-- START_2bb2423c56b9a07f0ef207856fcab770 -->
## core/cart
> Example request:

```javascript
const url = new URL(
    "arena.api/core/cart"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/cart`


<!-- END_2bb2423c56b9a07f0ef207856fcab770 -->

<!-- START_16473200da98c168ba3cb9d0fe9113f8 -->
## core/cart/method/{method}
> Example request:

```javascript
const url = new URL(
    "arena.api/core/cart/method/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET core/cart/method/{method}`


<!-- END_16473200da98c168ba3cb9d0fe9113f8 -->

<!-- START_7d78e554e2c25099cd7c99bff432503b -->
## core/mailing/email
> Example request:

```javascript
const url = new URL(
    "arena.api/core/mailing/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/mailing/email`


<!-- END_7d78e554e2c25099cd7c99bff432503b -->

<!-- START_da1b7984fe466271a3ef2fde3c99e857 -->
## core/cart/stripe/webhook
> Example request:

```javascript
const url = new URL(
    "arena.api/core/cart/stripe/webhook"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST core/cart/stripe/webhook`


<!-- END_da1b7984fe466271a3ef2fde3c99e857 -->

<!-- START_de714c1b7c5abea5747d7a250e614e57 -->
## mailing/email/{email}
> Example request:

```javascript
const url = new URL(
    "arena.api/mailing/email/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE mailing/email/{email}`


<!-- END_de714c1b7c5abea5747d7a250e614e57 -->

<!-- START_8e74014fea4b1c49c54b8bd0530196df -->
## vendors/slack/github
> Example request:

```javascript
const url = new URL(
    "arena.api/vendors/slack/github"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST vendors/slack/github`


<!-- END_8e74014fea4b1c49c54b8bd0530196df -->

<!-- START_64c87607e4ad5dff0e6dd9c9ddc8d0c8 -->
## vendors/slack/github/actions
> Example request:

```javascript
const url = new URL(
    "arena.api/vendors/slack/github/actions"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST vendors/slack/github/actions`


<!-- END_64c87607e4ad5dff0e6dd9c9ddc8d0c8 -->


