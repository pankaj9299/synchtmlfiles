<?php

namespace Drupal\oilgassync\Controller;

use Drupal\Core\Controller\ControllerBase;
use \Drupal\node\Entity\Node;

class WeatherPage extends ControllerBase
{
  public function getTitle($value): string
  {
    $parts = explode('_', $value);
    $lastSegment = end($parts);
    $str = explode('.', $lastSegment)[0];

    return $str;
  }
  public function build(): ?array 
  {
    $build = [];
    $directory = "public://output_html_files";
    $file_system = \Drupal::service('file_system');
    if ($file_system->prepareDirectory($directory, \Drupal\CORE\File\FileSystemInterface::MODIFY_PERMISSIONS)) {
      $files = scandir($directory);
      $files = array_diff($files, array('.', '..'));
      $count = 0;
      foreach ($files as $file) {
        if ($count < 1) {
          $title = $this->getTitle($file);
          $title = 'Resources #' . $title;

          $existing_node = \Drupal::entityQuery('node')
            ->condition('title', $title)
            ->range(0, 1)
            ->accessCheck(FALSE)
            ->execute();
          if (empty($existing_node)) {
            $file_path = $directory . '/' . $file;
            $file_content = file_get_contents($file_path);
            $node_data = [
              'type' => 'oil_and_gas',
              'title' => $title,
              'body' => [
                'value' => $file_content,
                'format' => 'full_html',
              ],
            ];
            $node = Node::create($node_data);
            $node->save();
            $build[] = [
              '#type' => 'markup',
              '#markup' => 'Node created with ID: ' . $node->id(),
            ];
          }
        }

        $count++;
      }

    }

    return $build;
  }
}
