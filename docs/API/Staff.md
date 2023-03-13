# Staff API

All URIs are relative to *http://localhost:8080/?api/staff/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getAll**](staff.md#getAll) | **Get** /staff | Get all staff
[**addStaff**](staff.md#addStaff) | **Post** /staff | add a staff
[**deleteStaff**](staff.md#deleteStaff) | **Post** /staff | delete a staff
[**updateStaff**](staff.md#updateStaff) | **Post** /staff | update a staff

# **getAll**
> /getall

Get all user

This can only be done by the logged in user.
### Example


### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------


### Return type

Success!
```json
{"status":true,"data":[{"ID":"1","USERNAME":"admin","PASSWORD":"123456","NAME":"V\u00f5 Tr\u1ecdng T\u00ecnh","CODE":"S5210085","PHONE":"0843206397","ADDRESS":"L\u00ea V\u0103n S\u1ef9, Q3, TP HCM","SALARY":"5000"},{"ID":"3","USERNAME":"admi","PASSWORD":"12345","NAME":"Lotte Cinema Q","CODE":"S5210085","PHONE":"084320639","ADDRESS":"Q7, Th\u00e0nh ph\u1ed1 H\u1ed3 Ch\u00ed min","SALARY":"500"}]}
```
Faild!
```json
{"status":false,"data":"An error 
occured."}
```

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json, application/xml, application/x-www-form-urlencoded
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../staff.md#documentation-for-api-endpoints) [[Back to Model list]](../../staff.md#documentation-for-models) [[Back to README]](../../staff.md)

# **addStaff**
> /add

Create staff

This can only be done by the logged in user.

### Example

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**|  | [optional]
 **USERNAME** | **string**|  | 
 **PASSWORD** | **string**|  | 
 **last_name** | **string**|  | 
 **NAME** | **string**|  | 
 **CODE** | **string**|  | 
 **PHONE** | **string**|  | 
 **ADDRESS** | **string**|  | 
 **SALARY** | **float**|  | 

### Return type

Success!
```json
{"status":true,"data":"Thêm nhân viên thành công"}
```
Faild!
```json
{"status":false,"data":"An error 
occured."}
```

### Authorization

No authorization required
# **deleteStaff**
> /delete

Create staff

This can only be done by the logged in user.

### Example

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**|  | 

### Return type

Success!
```json
{"status":true,"data":"Xóa nhân viên thành công"}
```
Faild!
```json
{"status":false,"data":"An error 
occured."}
```

### Authorization

No authorization required

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateStaff**
> /update

update staff

This can only be done by the logged in user.

### Example

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**|  | 
 **USERNAME** | **string**|  | 
 **PASSWORD** | **string**|  | 
 **last_name** | **string**|  | 
 **NAME** | **string**|  | 
 **CODE** | **string**|  | 
 **PHONE** | **string**|  | 
 **ADDRESS** | **string**|  | 
 **SALARY** | **float**|  | 

### Return type

Success!
```json
{"status":true,"data":"Cập nhật nhân viên thành công"}
```
Faild!
```json
{"status":false,"data":"An error 
occured."}
```

### Authorization

No authorization required