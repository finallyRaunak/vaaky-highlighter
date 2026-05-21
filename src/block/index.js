import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { RawHTML } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
    PanelBody,
    SelectControl,
    TextareaControl,
    TextControl,
    ToggleControl,
} from '@wordpress/components';
import metadata from '../../block.json';

const languages = [
    { label: __('Select a language', 'vaaky-highlighter'), value: '' },
    { label: 'Apache', value: 'apache' },
    { label: 'Bash', value: 'bash' },
    { label: 'C', value: 'c' },
    { label: 'C#', value: 'csharp' },
    { label: 'C++', value: 'cpp' },
    { label: 'CSS', value: 'css' },
    { label: 'DNS Zone file', value: 'dns' },
    { label: 'DOS', value: 'dos' },
    { label: 'Django', value: 'django' },
    { label: 'Dockerfile', value: 'dockerfile' },
    { label: 'Go', value: 'go' },
    { label: 'HTML', value: 'html' },
    { label: 'XML', value: 'xml' },
    { label: 'Handlebars', value: 'handlebars' },
    { label: 'JSON', value: 'json' },
    { label: 'Java', value: 'java' },
    { label: 'JavaScript', value: 'javascript' },
    { label: 'Markdown', value: 'markdown' },
    { label: 'Nginx', value: 'nginx' },
    { label: 'Objective-C', value: 'objectivec' },
    { label: 'PHP', value: 'php' },
    { label: 'Plaintext', value: 'plaintext' },
    { label: 'PostgreSQL', value: 'pgsql' },
    { label: 'PowerShell', value: 'powershell' },
    { label: 'Python', value: 'python' },
    { label: 'R', value: 'r' },
    { label: 'Ruby', value: 'ruby' },
    { label: 'Rust', value: 'rust' },
    { label: 'SCSS', value: 'scss' },
    { label: 'SQL', value: 'sql' },
    { label: 'Shell', value: 'shell' },
    { label: 'Twig', value: 'twig' },
    { label: 'TypeScript', value: 'typescript' },
    { label: 'YAML', value: 'yaml' },
];

function htmlEntities(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

registerBlockType(metadata.name, {
    edit: (props) => {
        const blockProps = useBlockProps({ className: 'vaaky-highlighter-editor' });
        const {
            attributes: { content, language, filename, showLineNumbers, wordWrap },
            setAttributes,
        } = props;

        return (
            <div {...blockProps}>
                <InspectorControls>
                    <PanelBody title={__('Vaaky Highlighter', 'vaaky-highlighter')}>
                        <SelectControl
                            label={__('Language', 'vaaky-highlighter')}
                            value={language}
                            options={languages}
                            onChange={(value) => setAttributes({ language: value })}
                        />
                        <TextControl
                            label={__('Filename (optional)', 'vaaky-highlighter')}
                            value={filename || ''}
                            onChange={(value) => setAttributes({ filename: value })}
                            help={__('Shows as a tab above the code block.', 'vaaky-highlighter')}
                        />
                        <ToggleControl
                            label={__('Show line numbers', 'vaaky-highlighter')}
                            checked={!!showLineNumbers}
                            onChange={(value) => setAttributes({ showLineNumbers: value })}
                            help={__('Leave off to use the global default.', 'vaaky-highlighter')}
                        />
                        <ToggleControl
                            label={__('Word wrap', 'vaaky-highlighter')}
                            checked={!!wordWrap}
                            onChange={(value) => setAttributes({ wordWrap: value })}
                            help={__('Wrap long lines instead of scrolling.', 'vaaky-highlighter')}
                        />
                    </PanelBody>
                </InspectorControls>

                {filename && (
                    <div className="vaaky-filename-preview">{filename}</div>
                )}
                <TextareaControl
                    label={__('Code Snippet', 'vaaky-highlighter')}
                    value={content}
                    onChange={(value) => setAttributes({ content: value })}
                    rows="10"
                />
            </div>
        );
    },
    save: (props) => {
        const {
            attributes: { content, language, filename, showLineNumbers, wordWrap },
        } = props;
        const parts = [
            `lang="${language || ''}"`,
            filename ? `filename="${htmlEntities(filename)}"` : '',
            showLineNumbers === true ? 'linenumbers="1"' : '',
            showLineNumbers === false ? 'linenumbers="0"' : '',
            wordWrap === true ? 'wrap="1"' : '',
            wordWrap === false ? 'wrap="0"' : '',
        ].filter(Boolean).join(' ');
        const shortcode = `[vaakyHighlighterCode ${parts}]${htmlEntities(content)}[/vaakyHighlighterCode]`;
        return (
            <div>
                <RawHTML>{shortcode}</RawHTML>
            </div>
        );
    },
});
