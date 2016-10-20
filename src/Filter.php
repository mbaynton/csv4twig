<?php
namespace mbaynton\CSV4Twig;

class Filter {
  /**
   * @var resource $mem_fd
   *   Handle to the php://temp resource.
   *   We keep it around rather than reallocating it for every field we escape.
   */
  protected static $mem_fd;

  /**
   * Registers the provided filter with a Twig environment.
   *
   * Currently, only a filter named 'csv' is registered.
   *
   * @param \Twig_Environment $environment
   *   The twig environment to register the CSV escaping filter in.
   * @return void
   */
  public static function registerFilters(\Twig_Environment $environment) {
    $environment->getExtension('core')
      ->setEscaper('csv', '\mbaynton\CSV4Twig\Filter::csv');
  }

  /**
   * Escapes a single field for safe inclusion into a CSV file.
   *
   * @param $twig_environment
   * @param string $data
   * @param string $charset
   * @return string
   */
  public static function csv($twig_environment, $data, $charset) {
    self::clearMemFd();
    fputcsv(self::$mem_fd, [$data]);
    rewind(self::$mem_fd);

    $result = '';
    while (! feof(self::$mem_fd)) {
      $result .= fread(self::$mem_fd, 16384);
    }
    self::clearMemFd();

    // fputcsv generously gave us a newline we don't want
    return substr($result, 0, -1);
  }

  /**
   * Make self::$mem_fd ready for use.
   */
  protected static function clearMemFd() {
    if (empty(self::$mem_fd)) {
      self::$mem_fd = fopen('php://temp', 'w+');
    } else {
      ftruncate(self::$mem_fd, 0);
    }
  }
}