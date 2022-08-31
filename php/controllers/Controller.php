<?php
class Controller
{
  public function __call($name, $arguments)
  {
    $this->sendNotFound('Method not found');
  }

  public function sendOutput($data, $ok, $httpHeaders = array())
  {
    header_remove('Set-Cookie');
    header('Content-Type: application/json');

    if (is_array($httpHeaders) && count($httpHeaders)) {
      foreach ($httpHeaders as $httpHeader) {
        header($httpHeader);
      }
    }

    echo $this->clean_response($data, $ok);
    exit;
  }

  public function clean_response($data, $ok)
  {
    if (!$ok) {

      if (!is_array($data)) {
        $data = array($data);
      }

      return json_encode(array(
        'messages' => $data,
        'ok' => false,
        'timestamp' => time()
      ));
    }

    return json_encode(array(
      'data' => $data,
      'ok' => true,
      'timestamp' => time()
    ));
  }

  public function fetch($method, $url, $data = null, $headers = array())
  {
    array_push($headers, 'Content-Type: application/json');

    $curl = curl_init();
    switch ($method) {
      case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data)
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
      case "PUT":
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if ($data)
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
      default:
        if ($data)
          $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // EXECUTE:
    $result = curl_exec($curl);
    if (!$result) {
      throw new Exception(curl_error($curl), 500);
    }
    curl_close($curl);
    return $result;
  }

  public function sendBadRequest($message)
  {
    $this->sendOutput($message, false, array('HTTP/1.1 400 Bad Request'));
  }

  public function sendUnauthorized($message)
  {
    $this->sendOutput($message, false, array('HTTP/1.1 401 Unauthorized'));
  }

  public function sendMethodNotAllowed($message)
  {
    $this->sendOutput($message, false, array('HTTP/1.1 405 Method Not Allowed'));
  }

  public function sendForbidden($message)
  {
    $this->sendOutput($message, false, array('HTTP/1.1 403 Forbidden'));
  }

  public function sendNotFound($message)
  {
    $this->sendOutput($message, false, array('HTTP/1.1 404 Not Found'));
  }

  public function sendInternalServerError($message)
  {
    $this->sendOutput($message, false, array('HTTP/1.1 500 Internal Server Error'));
  }

  public function sendNotImplemented($message)
  {
    $this->sendOutput($message, false, array('HTTP/1.1 501 Not Implemented'));
  }

  public function sendSuccess($data)
  {
    $this->sendOutput($data, true, array('HTTP/1.1 200 OK'));
  }

  public function sendCreated($message)
  {
    $this->sendOutput($message, true, array('HTTP/1.1 201 Created'));
  }

  public function sendNoContent()
  {
    $this->sendOutput(null, true, array('HTTP/1.1 204 No Content'));
  }
}
