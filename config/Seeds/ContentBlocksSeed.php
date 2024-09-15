<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class ContentBlocksSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'parent' => 'Global',
                'label' => 'Website Title',
                'description' => 'Shown on the home page, in the top left of the website, as well as any tabs in the users browser.',
                'slug' => 'website-title',// Slug = the attribute's ID we use to called in HTMl
                'type' => 'text',
                'value' => 'ClockWork',
            ],
            [
                'parent' => 'Global',
                'label' => 'Logo',
                'description' => 'Company and system logo, shown on the login page.',
                'slug' => 'website-logo',
                'type' => 'image',
            ],
            [
                'parent' => 'Global',
                'label' => 'Browser Icon',
                'description' => 'Icon shown in the browser tab.',
                'slug' => 'browser-logo',
                'type' => 'image',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Footer Logo',
                'description' => 'Icon shown in the footer on all pages.',
                'slug' => 'footer-logo',
                'type' => 'image',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Copy Right',
                'description' => 'Company copyright display.',
                'slug' => 'copy-right',
                'type' => 'html',
                'value' => '2024 nLive Company, Inc.',
            ],
            [
                'parent' => 'Email',
                'label' => 'Email Subject',
                'description' => 'Email subject for the system',
                'slug' => 'email-subject',
                'type' => 'text',
                'value' => 'Clockwork System New Account',
            ],
            [
                'parent' => 'Email',
                'label' => 'Email Content',
                'description' => 'Email content for the system',
                'slug' => 'email-content',
                'type' => 'html',
                'value' => 'This is the Clockwork System',
            ],
            [
                'parent' => 'Email',
                'label' => 'Email Footer',
                'description' => 'Email footer for the system',
                'slug' => 'email-footer',
                'type' => 'html',
                'value' => 'This is the Clockwork System',
            ],

            //add more editable content here, and re-bake on database using :
            //bin/cake migrations seed --seed ContentBlocksSeed
        ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
