import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { RawHTML } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextareaControl } from '@wordpress/components';
import metadata from '../../block.json';

const blockStyle = {
    backgroundColor: '#d8d3d6',
    color: '#000000',
    padding: '20px',
};

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
        const blockProps = useBlockProps({ style: blockStyle, className: 'vaaky-highlighter' });
        const {
            attributes: { content, language },
            setAttributes,
            className,
        } = props;

        return (
            <div className={className} {...blockProps}>
                <InspectorControls>
                    <PanelBody title={__('Vaaky Highlighter Settings', 'vaaky-highlighter')}>
                        <SelectControl
                            label={__('Language', 'vaaky-highlighter')}
                            value={language}
                            options={languages}
                            onChange={(value) => setAttributes({ language: value })}
                        />
                    </PanelBody>
                </InspectorControls>

                <TextareaControl
                    label="Code Snippet"
                    value={content}
                    onChange={(value) => setAttributes({ content: value })}
                    rows="10"
                />
            </div>
        );
    },
    save: (props) => {
        const {
            attributes: { content, language },
        } = props;
        const shortcode =
            '[vaakyHighlighterCode lang="' + language + '"]' +
            htmlEntities(content) +
            '[/vaakyHighlighterCode]';
        return (
            <div>
                <RawHTML>{shortcode}</RawHTML>
            </div>
        );
    },
});
