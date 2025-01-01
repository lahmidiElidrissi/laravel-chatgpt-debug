<?php

namespace lahmidielidrissi\DebugHelper;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class DebugHelperHandler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        $response = parent::render($request, $exception);

        if (app()->environment('local') && $response->getStatusCode() === 500) {
            $content = $response->getContent();
            $buttonHtml = $this->getDebugButtonHtml($exception);
            $content = str_replace('</body>', $buttonHtml . '</body>', $content);
            $response->setContent($content);
        }

        return $response;
    }

    private function getDebugButtonHtml(Throwable $exception)
    {
        $errorMessage = htmlspecialchars($exception->getMessage());
        return <<<HTML
            <button onclick="fetchSuggestion('$errorMessage')" style="position: fixed; bottom: 20px; right: 20px; background: #007BFF; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                Get ChatGPT Suggestion
            </button>
            <div id="debugHelperModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
                <div style="background: white; padding: 20px; border-radius: 5px; max-width: 500px; width: 100%; text-align: center;">
                    <h2>ChatGPT Suggestions</h2>
                    <p id="suggestionText"></p>
                    <button onclick="closeModal()" style="margin-top: 20px; background: red; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Close</button>
                </div>
            </div>
            <script>
                function fetchSuggestion(errorMessage) {
                    fetch('/debug-helper/suggestion', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ error: errorMessage })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('suggestionText').innerText = data.suggestion;
                        document.getElementById('debugHelperModal').style.display = 'flex';
                    });
                }

                function closeModal() {
                    document.getElementById('debugHelperModal').style.display = 'none';
                }
            </script>
        HTML;
    }
}
