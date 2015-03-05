# ssn-web
web applications for SSN project

##web service API

url: /ssn

###Common parameters
Headers:
ssn-acc: - account number
ssn-obj: - object number
ssn-base64: use or not base64 in request (1/0)
ssn-aes128: use or not AES128 encoding in request (1/0)

###GET

t - token with request data

###example:
http://host_addr/ssn/index.php?t=gUXFD0sguWQmq5n0f9iOiw==

Request headers:
ssn-acc: 1
ssn-obj: 1
ssn-base64: 1
ssn-aes128: 1

###POST
Content-Type: application/octet-stream

Body - JSON data (encoded or not)
