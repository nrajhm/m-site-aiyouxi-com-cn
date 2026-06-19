<?php

class LinkCard
{
    private array $config;

    private const DEFAULT_CONFIG = [
        'site_url' => 'https://m-site-aiyouxi.com.cn',
        'site_name' => '爱游戏',
        'fallback_title' => '爱游戏 - 精彩游戏平台',
        'fallback_description' => '发现更多好玩游戏，尽在爱游戏。',
        'max_title_length' => 60,
        'max_description_length' => 120,
    ];

    public function __construct(array $customConfig = [])
    {
        $this->config = array_merge(self::DEFAULT_CONFIG, $customConfig);
    }

    public function renderCard(array $data = []): string
    {
        $title = $this->truncateString(
            $data['title'] ?? $this->config['fallback_title'],
            $this->config['max_title_length']
        );

        $description = $this->truncateString(
            $data['description'] ?? $this->config['fallback_description'],
            $this->config['max_description_length']
        );

        $url = $data['url'] ?? $this->config['site_url'];
        $imageUrl = $data['image_url'] ?? '';
        $siteName = $data['site_name'] ?? $this->config['site_name'];

        $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeDescription = htmlspecialchars($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeUrl = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeImageUrl = htmlspecialchars($imageUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeSiteName = htmlspecialchars($siteName, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $imageHtml = '';
        if ($safeImageUrl !== '') {
            $imageHtml = sprintf(
                '<div class="link-card-image"><img src="%s" alt="%s" /></div>',
                $safeImageUrl,
                $safeTitle
            );
        }

        return sprintf(
            '<div class="link-card">' .
                '%s' .
                '<div class="link-card-body">' .
                    '<h3 class="link-card-title">%s</h3>' .
                    '<p class="link-card-description">%s</p>' .
                    '<span class="link-card-site">%s</span>' .
                '</div>' .
                '<a class="link-card-link" href="%s" target="_blank" rel="noopener noreferrer">查看详情</a>' .
            '</div>',
            $imageHtml,
            $safeTitle,
            $safeDescription,
            $safeSiteName,
            $safeUrl
        );
    }

    public function renderSampleCard(): string
    {
        $sampleData = [
            'title' => '爱游戏 - 热门手游推荐',
            'description' => '汇聚最新最热手游大作，爱游戏平台为您精选每一款好游戏。',
            'url' => 'https://m-site-aiyouxi.com.cn/games',
            'image_url' => 'https://m-site-aiyouxi.com.cn/images/sample-banner.jpg',
            'site_name' => '爱游戏',
        ];

        return $this->renderCard($sampleData);
    }

    public function createCardFromInput(string $inputUrl, string $inputTitle = ''): string
    {
        $title = $inputTitle !== '' ? $inputTitle : $this->config['fallback_title'];

        $data = [
            'title' => $title,
            'description' => sprintf('来自 %s 的精彩内容，爱游戏为您呈现。', $this->config['site_name']),
            'url' => $inputUrl !== '' ? $inputUrl : $this->config['site_url'],
            'site_name' => $this->config['site_name'],
        ];

        return $this->renderCard($data);
    }

    private function truncateString(string $str, int $maxLength): string
    {
        if (mb_strlen($str, 'UTF-8') <= $maxLength) {
            return $str;
        }

        return mb_substr($str, 0, $maxLength - 3, 'UTF-8') . '...';
    }
}

function renderLinkCard(array $customData = []): string
{
    $defaultData = [
        'title' => '爱游戏 - 游戏爱好者的乐园',
        'description' => '爱游戏平台提供丰富多样的游戏选择，满足不同玩家的需求。',
        'url' => 'https://m-site-aiyouxi.com.cn',
        'image_url' => '',
        'site_name' => '爱游戏',
    ];

    $mergedData = array_merge($defaultData, $customData);

    $safeTitle = htmlspecialchars($mergedData['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeDescription = htmlspecialchars($mergedData['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeUrl = htmlspecialchars($mergedData['url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeImageUrl = htmlspecialchars($mergedData['image_url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeSiteName = htmlspecialchars($mergedData['site_name'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $imageBlock = '';
    if ($safeImageUrl !== '') {
        $imageBlock = sprintf(
            '<div class="link-card-image"><img src="%s" alt="%s" loading="lazy" /></div>',
            $safeImageUrl,
            $safeTitle
        );
    }

    return sprintf(
        '<div class="link-card link-card-basic">' .
            '%s' .
            '<div class="link-card-content">' .
                '<h4 class="link-card-heading">%s</h4>' .
                '<p class="link-card-text">%s</p>' .
                '<cite class="link-card-source">%s</cite>' .
            '</div>' .
            '<a class="link-card-anchor" href="%s" target="_blank" rel="noopener noreferrer">访问链接</a>' .
        '</div>',
        $imageBlock,
        $safeTitle,
        $safeDescription,
        $safeSiteName,
        $safeUrl
    );
}