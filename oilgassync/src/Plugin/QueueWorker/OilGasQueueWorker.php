<?php

namespace Drupal\oilgassync\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use \Drupal\node\Entity\Node;

/**
 * @QueueWorker(
 * 
 * id = "oilgassync_queue_worker",
 * title = @Translation("Oil Gas Sync Queue Worker"),
 * cron = {"time" = 60}
 * )
 */
class OilGasQueueWorker extends QueueWorkerBase
{
    public function getTitle($value): string
    {
        $parts = explode('_', $value);
        $lastSegment = end($parts);
        $str = explode('.', $lastSegment)[0];

        return $str;
    }
    /**
     * {@inheritdoc}
     */
    public function processItem($data)
    {
        $directory = "public://output_html_files";
        $file_system = \Drupal::service('file_system');
        if ($file_system->prepareDirectory($directory, \Drupal\CORE\File\FileSystemInterface::MODIFY_PERMISSIONS)) {
            $files = scandir($directory);
            $files = array_diff($files, array('.', '..'));
            foreach ($files as $file) {
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
                    \Drupal::logger('oilgassync')->notice('Queue item being processed.');
                }
            }
        }
    }
}
