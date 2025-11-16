<!DOCTYPE html>

<html lang="en">
<head><meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>k-means</title><script src="https://cdnjs.cloudflare.com/ajax/libs/require.js/2.1.10/require.min.js"></script>
<style type="text/css">
    pre { line-height: 125%; }
td.linenos .normal { color: inherit; background-color: transparent; padding-left: 5px; padding-right: 5px; }
span.linenos { color: inherit; background-color: transparent; padding-left: 5px; padding-right: 5px; }
td.linenos .special { color: #000000; background-color: #ffffc0; padding-left: 5px; padding-right: 5px; }
span.linenos.special { color: #000000; background-color: #ffffc0; padding-left: 5px; padding-right: 5px; }
.highlight .hll { background-color: var(--jp-cell-editor-active-background) }
.highlight { background: var(--jp-cell-editor-background); color: var(--jp-mirror-editor-variable-color) }
.highlight .c { color: var(--jp-mirror-editor-comment-color); font-style: italic } /* Comment */
.highlight .err { color: var(--jp-mirror-editor-error-color) } /* Error */
.highlight .k { color: var(--jp-mirror-editor-keyword-color); font-weight: bold } /* Keyword */
.highlight .o { color: var(--jp-mirror-editor-operator-color); font-weight: bold } /* Operator */
.highlight .p { color: var(--jp-mirror-editor-punctuation-color) } /* Punctuation */
.highlight .ch { color: var(--jp-mirror-editor-comment-color); font-style: italic } /* Comment.Hashbang */
.highlight .cm { color: var(--jp-mirror-editor-comment-color); font-style: italic } /* Comment.Multiline */
.highlight .cp { color: var(--jp-mirror-editor-comment-color); font-style: italic } /* Comment.Preproc */
.highlight .cpf { color: var(--jp-mirror-editor-comment-color); font-style: italic } /* Comment.PreprocFile */
.highlight .c1 { color: var(--jp-mirror-editor-comment-color); font-style: italic } /* Comment.Single */
.highlight .cs { color: var(--jp-mirror-editor-comment-color); font-style: italic } /* Comment.Special */
.highlight .kc { color: var(--jp-mirror-editor-keyword-color); font-weight: bold } /* Keyword.Constant */
.highlight .kd { color: var(--jp-mirror-editor-keyword-color); font-weight: bold } /* Keyword.Declaration */
.highlight .kn { color: var(--jp-mirror-editor-keyword-color); font-weight: bold } /* Keyword.Namespace */
.highlight .kp { color: var(--jp-mirror-editor-keyword-color); font-weight: bold } /* Keyword.Pseudo */
.highlight .kr { color: var(--jp-mirror-editor-keyword-color); font-weight: bold } /* Keyword.Reserved */
.highlight .kt { color: var(--jp-mirror-editor-keyword-color); font-weight: bold } /* Keyword.Type */
.highlight .m { color: var(--jp-mirror-editor-number-color) } /* Literal.Number */
.highlight .s { color: var(--jp-mirror-editor-string-color) } /* Literal.String */
.highlight .ow { color: var(--jp-mirror-editor-operator-color); font-weight: bold } /* Operator.Word */
.highlight .pm { color: var(--jp-mirror-editor-punctuation-color) } /* Punctuation.Marker */
.highlight .w { color: var(--jp-mirror-editor-variable-color) } /* Text.Whitespace */
.highlight .mb { color: var(--jp-mirror-editor-number-color) } /* Literal.Number.Bin */
.highlight .mf { color: var(--jp-mirror-editor-number-color) } /* Literal.Number.Float */
.highlight .mh { color: var(--jp-mirror-editor-number-color) } /* Literal.Number.Hex */
.highlight .mi { color: var(--jp-mirror-editor-number-color) } /* Literal.Number.Integer */
.highlight .mo { color: var(--jp-mirror-editor-number-color) } /* Literal.Number.Oct */
.highlight .sa { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Affix */
.highlight .sb { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Backtick */
.highlight .sc { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Char */
.highlight .dl { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Delimiter */
.highlight .sd { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Doc */
.highlight .s2 { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Double */
.highlight .se { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Escape */
.highlight .sh { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Heredoc */
.highlight .si { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Interpol */
.highlight .sx { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Other */
.highlight .sr { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Regex */
.highlight .s1 { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Single */
.highlight .ss { color: var(--jp-mirror-editor-string-color) } /* Literal.String.Symbol */
.highlight .il { color: var(--jp-mirror-editor-number-color) } /* Literal.Number.Integer.Long */
  </style>
<style type="text/css">
/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*
 * Mozilla scrollbar styling
 */

/* use standard opaque scrollbars for most nodes */
[data-jp-theme-scrollbars='true'] {
  scrollbar-color: rgb(var(--jp-scrollbar-thumb-color))
    var(--jp-scrollbar-background-color);
}

/* for code nodes, use a transparent style of scrollbar. These selectors
 * will match lower in the tree, and so will override the above */
[data-jp-theme-scrollbars='true'] .CodeMirror-hscrollbar,
[data-jp-theme-scrollbars='true'] .CodeMirror-vscrollbar {
  scrollbar-color: rgba(var(--jp-scrollbar-thumb-color), 0.5) transparent;
}

/* tiny scrollbar */

.jp-scrollbar-tiny {
  scrollbar-color: rgba(var(--jp-scrollbar-thumb-color), 0.5) transparent;
  scrollbar-width: thin;
}

/* tiny scrollbar */

.jp-scrollbar-tiny::-webkit-scrollbar,
.jp-scrollbar-tiny::-webkit-scrollbar-corner {
  background-color: transparent;
  height: 4px;
  width: 4px;
}

.jp-scrollbar-tiny::-webkit-scrollbar-thumb {
  background: rgba(var(--jp-scrollbar-thumb-color), 0.5);
}

.jp-scrollbar-tiny::-webkit-scrollbar-track:horizontal {
  border-left: 0 solid transparent;
  border-right: 0 solid transparent;
}

.jp-scrollbar-tiny::-webkit-scrollbar-track:vertical {
  border-top: 0 solid transparent;
  border-bottom: 0 solid transparent;
}

/*
 * Lumino
 */

.lm-ScrollBar[data-orientation='horizontal'] {
  min-height: 16px;
  max-height: 16px;
  min-width: 45px;
  border-top: 1px solid #a0a0a0;
}

.lm-ScrollBar[data-orientation='vertical'] {
  min-width: 16px;
  max-width: 16px;
  min-height: 45px;
  border-left: 1px solid #a0a0a0;
}

.lm-ScrollBar-button {
  background-color: #f0f0f0;
  background-position: center center;
  min-height: 15px;
  max-height: 15px;
  min-width: 15px;
  max-width: 15px;
}

.lm-ScrollBar-button:hover {
  background-color: #dadada;
}

.lm-ScrollBar-button.lm-mod-active {
  background-color: #cdcdcd;
}

.lm-ScrollBar-track {
  background: #f0f0f0;
}

.lm-ScrollBar-thumb {
  background: #cdcdcd;
}

.lm-ScrollBar-thumb:hover {
  background: #bababa;
}

.lm-ScrollBar-thumb.lm-mod-active {
  background: #a0a0a0;
}

.lm-ScrollBar[data-orientation='horizontal'] .lm-ScrollBar-thumb {
  height: 100%;
  min-width: 15px;
  border-left: 1px solid #a0a0a0;
  border-right: 1px solid #a0a0a0;
}

.lm-ScrollBar[data-orientation='vertical'] .lm-ScrollBar-thumb {
  width: 100%;
  min-height: 15px;
  border-top: 1px solid #a0a0a0;
  border-bottom: 1px solid #a0a0a0;
}

.lm-ScrollBar[data-orientation='horizontal']
  .lm-ScrollBar-button[data-action='decrement'] {
  background-image: var(--jp-icon-caret-left);
  background-size: 17px;
}

.lm-ScrollBar[data-orientation='horizontal']
  .lm-ScrollBar-button[data-action='increment'] {
  background-image: var(--jp-icon-caret-right);
  background-size: 17px;
}

.lm-ScrollBar[data-orientation='vertical']
  .lm-ScrollBar-button[data-action='decrement'] {
  background-image: var(--jp-icon-caret-up);
  background-size: 17px;
}

.lm-ScrollBar[data-orientation='vertical']
  .lm-ScrollBar-button[data-action='increment'] {
  background-image: var(--jp-icon-caret-down);
  background-size: 17px;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-Widget {
  box-sizing: border-box;
  position: relative;
  overflow: hidden;
}

.lm-Widget.lm-mod-hidden {
  display: none !important;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

.lm-AccordionPanel[data-orientation='horizontal'] > .lm-AccordionPanel-title {
  /* Title is rotated for horizontal accordion panel using CSS */
  display: block;
  transform-origin: top left;
  transform: rotate(-90deg) translate(-100%);
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-CommandPalette {
  display: flex;
  flex-direction: column;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.lm-CommandPalette-search {
  flex: 0 0 auto;
}

.lm-CommandPalette-content {
  flex: 1 1 auto;
  margin: 0;
  padding: 0;
  min-height: 0;
  overflow: auto;
  list-style-type: none;
}

.lm-CommandPalette-header {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.lm-CommandPalette-item {
  display: flex;
  flex-direction: row;
}

.lm-CommandPalette-itemIcon {
  flex: 0 0 auto;
}

.lm-CommandPalette-itemContent {
  flex: 1 1 auto;
  overflow: hidden;
}

.lm-CommandPalette-itemShortcut {
  flex: 0 0 auto;
}

.lm-CommandPalette-itemLabel {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.lm-close-icon {
  border: 1px solid transparent;
  background-color: transparent;
  position: absolute;
  z-index: 1;
  right: 3%;
  top: 0;
  bottom: 0;
  margin: auto;
  padding: 7px 0;
  display: none;
  vertical-align: middle;
  outline: 0;
  cursor: pointer;
}
.lm-close-icon:after {
  content: 'X';
  display: block;
  width: 15px;
  height: 15px;
  text-align: center;
  color: #000;
  font-weight: normal;
  font-size: 12px;
  cursor: pointer;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-DockPanel {
  z-index: 0;
}

.lm-DockPanel-widget {
  z-index: 0;
}

.lm-DockPanel-tabBar {
  z-index: 1;
}

.lm-DockPanel-handle {
  z-index: 2;
}

.lm-DockPanel-handle.lm-mod-hidden {
  display: none !important;
}

.lm-DockPanel-handle:after {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  content: '';
}

.lm-DockPanel-handle[data-orientation='horizontal'] {
  cursor: ew-resize;
}

.lm-DockPanel-handle[data-orientation='vertical'] {
  cursor: ns-resize;
}

.lm-DockPanel-handle[data-orientation='horizontal']:after {
  left: 50%;
  min-width: 8px;
  transform: translateX(-50%);
}

.lm-DockPanel-handle[data-orientation='vertical']:after {
  top: 50%;
  min-height: 8px;
  transform: translateY(-50%);
}

.lm-DockPanel-overlay {
  z-index: 3;
  box-sizing: border-box;
  pointer-events: none;
}

.lm-DockPanel-overlay.lm-mod-hidden {
  display: none !important;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-Menu {
  z-index: 10000;
  position: absolute;
  white-space: nowrap;
  overflow-x: hidden;
  overflow-y: auto;
  outline: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.lm-Menu-content {
  margin: 0;
  padding: 0;
  display: table;
  list-style-type: none;
}

.lm-Menu-item {
  display: table-row;
}

.lm-Menu-item.lm-mod-hidden,
.lm-Menu-item.lm-mod-collapsed {
  display: none !important;
}

.lm-Menu-itemIcon,
.lm-Menu-itemSubmenuIcon {
  display: table-cell;
  text-align: center;
}

.lm-Menu-itemLabel {
  display: table-cell;
  text-align: left;
}

.lm-Menu-itemShortcut {
  display: table-cell;
  text-align: right;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-MenuBar {
  outline: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.lm-MenuBar-content {
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: row;
  list-style-type: none;
}

.lm-MenuBar-item {
  box-sizing: border-box;
}

.lm-MenuBar-itemIcon,
.lm-MenuBar-itemLabel {
  display: inline-block;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-ScrollBar {
  display: flex;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.lm-ScrollBar[data-orientation='horizontal'] {
  flex-direction: row;
}

.lm-ScrollBar[data-orientation='vertical'] {
  flex-direction: column;
}

.lm-ScrollBar-button {
  box-sizing: border-box;
  flex: 0 0 auto;
}

.lm-ScrollBar-track {
  box-sizing: border-box;
  position: relative;
  overflow: hidden;
  flex: 1 1 auto;
}

.lm-ScrollBar-thumb {
  box-sizing: border-box;
  position: absolute;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-SplitPanel-child {
  z-index: 0;
}

.lm-SplitPanel-handle {
  z-index: 1;
}

.lm-SplitPanel-handle.lm-mod-hidden {
  display: none !important;
}

.lm-SplitPanel-handle:after {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  content: '';
}

.lm-SplitPanel[data-orientation='horizontal'] > .lm-SplitPanel-handle {
  cursor: ew-resize;
}

.lm-SplitPanel[data-orientation='vertical'] > .lm-SplitPanel-handle {
  cursor: ns-resize;
}

.lm-SplitPanel[data-orientation='horizontal'] > .lm-SplitPanel-handle:after {
  left: 50%;
  min-width: 8px;
  transform: translateX(-50%);
}

.lm-SplitPanel[data-orientation='vertical'] > .lm-SplitPanel-handle:after {
  top: 50%;
  min-height: 8px;
  transform: translateY(-50%);
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-TabBar {
  display: flex;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.lm-TabBar[data-orientation='horizontal'] {
  flex-direction: row;
  align-items: flex-end;
}

.lm-TabBar[data-orientation='vertical'] {
  flex-direction: column;
  align-items: flex-end;
}

.lm-TabBar-content {
  margin: 0;
  padding: 0;
  display: flex;
  flex: 1 1 auto;
  list-style-type: none;
}

.lm-TabBar[data-orientation='horizontal'] > .lm-TabBar-content {
  flex-direction: row;
}

.lm-TabBar[data-orientation='vertical'] > .lm-TabBar-content {
  flex-direction: column;
}

.lm-TabBar-tab {
  display: flex;
  flex-direction: row;
  box-sizing: border-box;
  overflow: hidden;
  touch-action: none; /* Disable native Drag/Drop */
}

.lm-TabBar-tabIcon,
.lm-TabBar-tabCloseIcon {
  flex: 0 0 auto;
}

.lm-TabBar-tabLabel {
  flex: 1 1 auto;
  overflow: hidden;
  white-space: nowrap;
}

.lm-TabBar-tabInput {
  user-select: all;
  width: 100%;
  box-sizing: border-box;
}

.lm-TabBar-tab.lm-mod-hidden {
  display: none !important;
}

.lm-TabBar-addButton.lm-mod-hidden {
  display: none !important;
}

.lm-TabBar.lm-mod-dragging .lm-TabBar-tab {
  position: relative;
}

.lm-TabBar.lm-mod-dragging[data-orientation='horizontal'] .lm-TabBar-tab {
  left: 0;
  transition: left 150ms ease;
}

.lm-TabBar.lm-mod-dragging[data-orientation='vertical'] .lm-TabBar-tab {
  top: 0;
  transition: top 150ms ease;
}

.lm-TabBar.lm-mod-dragging .lm-TabBar-tab.lm-mod-dragging {
  transition: none;
}

.lm-TabBar-tabLabel .lm-TabBar-tabInput {
  user-select: all;
  width: 100%;
  box-sizing: border-box;
  background: inherit;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-TabPanel-tabBar {
  z-index: 1;
}

.lm-TabPanel-stackedPanel {
  z-index: 0;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-Collapse {
  display: flex;
  flex-direction: column;
  align-items: stretch;
}

.jp-Collapse-header {
  padding: 1px 12px;
  background-color: var(--jp-layout-color1);
  border-bottom: solid var(--jp-border-width) var(--jp-border-color2);
  color: var(--jp-ui-font-color1);
  cursor: pointer;
  display: flex;
  align-items: center;
  font-size: var(--jp-ui-font-size0);
  font-weight: 600;
  text-transform: uppercase;
  user-select: none;
}

.jp-Collapser-icon {
  height: 16px;
}

.jp-Collapse-header-collapsed .jp-Collapser-icon {
  transform: rotate(-90deg);
  margin: auto 0;
}

.jp-Collapser-title {
  line-height: 25px;
}

.jp-Collapse-contents {
  padding: 0 12px;
  background-color: var(--jp-layout-color1);
  color: var(--jp-ui-font-color1);
  overflow: auto;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/* This file was auto-generated by ensureUiComponents() in @jupyterlab/buildutils */

/**
 * (DEPRECATED) Support for consuming icons as CSS background images
 */

/* Icons urls */

:root {
  --jp-icon-add-above: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iMTQiIHZpZXdCb3g9IjAgMCAxNCAxNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzEzN18xOTQ5MikiPgo8cGF0aCBjbGFzcz0ianAtaWNvbjMiIGQ9Ik00Ljc1IDQuOTMwNjZINi42MjVWNi44MDU2NkM2LjYyNSA3LjAxMTkxIDYuNzkzNzUgNy4xODA2NiA3IDcuMTgwNjZDNy4yMDYyNSA3LjE4MDY2IDcuMzc1IDcuMDExOTEgNy4zNzUgNi44MDU2NlY0LjkzMDY2SDkuMjVDOS40NTYyNSA0LjkzMDY2IDkuNjI1IDQuNzYxOTEgOS42MjUgNC41NTU2NkM5LjYyNSA0LjM0OTQxIDkuNDU2MjUgNC4xODA2NiA5LjI1IDQuMTgwNjZINy4zNzVWMi4zMDU2NkM3LjM3NSAyLjA5OTQxIDcuMjA2MjUgMS45MzA2NiA3IDEuOTMwNjZDNi43OTM3NSAxLjkzMDY2IDYuNjI1IDIuMDk5NDEgNi42MjUgMi4zMDU2NlY0LjE4MDY2SDQuNzVDNC41NDM3NSA0LjE4MDY2IDQuMzc1IDQuMzQ5NDEgNC4zNzUgNC41NTU2NkM0LjM3NSA0Ljc2MTkxIDQuNTQzNzUgNC45MzA2NiA0Ljc1IDQuOTMwNjZaIiBmaWxsPSIjNjE2MTYxIiBzdHJva2U9IiM2MTYxNjEiIHN0cm9rZS13aWR0aD0iMC43Ii8+CjwvZz4KPHBhdGggY2xhc3M9ImpwLWljb24zIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTExLjUgOS41VjExLjVMMi41IDExLjVWOS41TDExLjUgOS41Wk0xMiA4QzEyLjU1MjMgOCAxMyA4LjQ0NzcyIDEzIDlWMTJDMTMgMTIuNTUyMyAxMi41NTIzIDEzIDEyIDEzTDIgMTNDMS40NDc3MiAxMyAxIDEyLjU1MjMgMSAxMlY5QzEgOC40NDc3MiAxLjQ0NzcxIDggMiA4TDEyIDhaIiBmaWxsPSIjNjE2MTYxIi8+CjxkZWZzPgo8Y2xpcFBhdGggaWQ9ImNsaXAwXzEzN18xOTQ5MiI+CjxyZWN0IGNsYXNzPSJqcC1pY29uMyIgd2lkdGg9IjYiIGhlaWdodD0iNiIgZmlsbD0id2hpdGUiIHRyYW5zZm9ybT0ibWF0cml4KC0xIDAgMCAxIDEwIDEuNTU1NjYpIi8+CjwvY2xpcFBhdGg+CjwvZGVmcz4KPC9zdmc+Cg==);
  --jp-icon-add-below: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iMTQiIHZpZXdCb3g9IjAgMCAxNCAxNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzEzN18xOTQ5OCkiPgo8cGF0aCBjbGFzcz0ianAtaWNvbjMiIGQ9Ik05LjI1IDEwLjA2OTNMNy4zNzUgMTAuMDY5M0w3LjM3NSA4LjE5NDM0QzcuMzc1IDcuOTg4MDkgNy4yMDYyNSA3LjgxOTM0IDcgNy44MTkzNEM2Ljc5Mzc1IDcuODE5MzQgNi42MjUgNy45ODgwOSA2LjYyNSA4LjE5NDM0TDYuNjI1IDEwLjA2OTNMNC43NSAxMC4wNjkzQzQuNTQzNzUgMTAuMDY5MyA0LjM3NSAxMC4yMzgxIDQuMzc1IDEwLjQ0NDNDNC4zNzUgMTAuNjUwNiA0LjU0Mzc1IDEwLjgxOTMgNC43NSAxMC44MTkzTDYuNjI1IDEwLjgxOTNMNi42MjUgMTIuNjk0M0M2LjYyNSAxMi45MDA2IDYuNzkzNzUgMTMuMDY5MyA3IDEzLjA2OTNDNy4yMDYyNSAxMy4wNjkzIDcuMzc1IDEyLjkwMDYgNy4zNzUgMTIuNjk0M0w3LjM3NSAxMC44MTkzTDkuMjUgMTAuODE5M0M5LjQ1NjI1IDEwLjgxOTMgOS42MjUgMTAuNjUwNiA5LjYyNSAxMC40NDQzQzkuNjI1IDEwLjIzODEgOS40NTYyNSAxMC4wNjkzIDkuMjUgMTAuMDY5M1oiIGZpbGw9IiM2MTYxNjEiIHN0cm9rZT0iIzYxNjE2MSIgc3Ryb2tlLXdpZHRoPSIwLjciLz4KPC9nPgo8cGF0aCBjbGFzcz0ianAtaWNvbjMiIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBkPSJNMi41IDUuNUwyLjUgMy41TDExLjUgMy41TDExLjUgNS41TDIuNSA1LjVaTTIgN0MxLjQ0NzcyIDcgMSA2LjU1MjI4IDEgNkwxIDNDMSAyLjQ0NzcyIDEuNDQ3NzIgMiAyIDJMMTIgMkMxMi41NTIzIDIgMTMgMi40NDc3MiAxMyAzTDEzIDZDMTMgNi41NTIyOSAxMi41NTIzIDcgMTIgN0wyIDdaIiBmaWxsPSIjNjE2MTYxIi8+CjxkZWZzPgo8Y2xpcFBhdGggaWQ9ImNsaXAwXzEzN18xOTQ5OCI+CjxyZWN0IGNsYXNzPSJqcC1pY29uMyIgd2lkdGg9IjYiIGhlaWdodD0iNiIgZmlsbD0id2hpdGUiIHRyYW5zZm9ybT0ibWF0cml4KDEgMS43NDg0NmUtMDcgMS43NDg0NmUtMDcgLTEgNCAxMy40NDQzKSIvPgo8L2NsaXBQYXRoPgo8L2RlZnM+Cjwvc3ZnPgo=);
  --jp-icon-add: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTE5IDEzaC02djZoLTJ2LTZINXYtMmg2VjVoMnY2aDZ2MnoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-bell: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDE2IDE2IiB2ZXJzaW9uPSIxLjEiPgogICA8cGF0aCBjbGFzcz0ianAtaWNvbjIganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjMzMzMzMzIgogICAgICBkPSJtOCAwLjI5Yy0xLjQgMC0yLjcgMC43My0zLjYgMS44LTEuMiAxLjUtMS40IDMuNC0xLjUgNS4yLTAuMTggMi4yLTAuNDQgNC0yLjMgNS4zbDAuMjggMS4zaDVjMC4wMjYgMC42NiAwLjMyIDEuMSAwLjcxIDEuNSAwLjg0IDAuNjEgMiAwLjYxIDIuOCAwIDAuNTItMC40IDAuNi0xIDAuNzEtMS41aDVsMC4yOC0xLjNjLTEuOS0wLjk3LTIuMi0zLjMtMi4zLTUuMy0wLjEzLTEuOC0wLjI2LTMuNy0xLjUtNS4yLTAuODUtMS0yLjItMS44LTMuNi0xLjh6bTAgMS40YzAuODggMCAxLjkgMC41NSAyLjUgMS4zIDAuODggMS4xIDEuMSAyLjcgMS4yIDQuNCAwLjEzIDEuNyAwLjIzIDMuNiAxLjMgNS4yaC0xMGMxLjEtMS42IDEuMi0zLjQgMS4zLTUuMiAwLjEzLTEuNyAwLjMtMy4zIDEuMi00LjQgMC41OS0wLjcyIDEuNi0xLjMgMi41LTEuM3ptLTAuNzQgMTJoMS41Yy0wLjAwMTUgMC4yOCAwLjAxNSAwLjc5LTAuNzQgMC43OS0wLjczIDAuMDAxNi0wLjcyLTAuNTMtMC43NC0wLjc5eiIgLz4KPC9zdmc+Cg==);
  --jp-icon-bug-dot: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyBqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiM2MTYxNjEiPgogICAgICAgIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBkPSJNMTcuMTkgOEgyMFYxMEgxNy45MUMxNy45NiAxMC4zMyAxOCAxMC42NiAxOCAxMVYxMkgyMFYxNEgxOC41SDE4VjE0LjAyNzVDMTUuNzUgMTQuMjc2MiAxNCAxNi4xODM3IDE0IDE4LjVDMTQgMTkuMjA4IDE0LjE2MzUgMTkuODc3OSAxNC40NTQ5IDIwLjQ3MzlDMTMuNzA2MyAyMC44MTE3IDEyLjg3NTcgMjEgMTIgMjFDOS43OCAyMSA3Ljg1IDE5Ljc5IDYuODEgMThINFYxNkg2LjA5QzYuMDQgMTUuNjcgNiAxNS4zNCA2IDE1VjE0SDRWMTJINlYxMUM2IDEwLjY2IDYuMDQgMTAuMzMgNi4wOSAxMEg0VjhINi44MUM3LjI2IDcuMjIgNy44OCA2LjU1IDguNjIgNi4wNEw3IDQuNDFMOC40MSAzTDEwLjU5IDUuMTdDMTEuMDQgNS4wNiAxMS41MSA1IDEyIDVDMTIuNDkgNSAxMi45NiA1LjA2IDEzLjQyIDUuMTdMMTUuNTkgM0wxNyA0LjQxTDE1LjM3IDYuMDRDMTYuMTIgNi41NSAxNi43NCA3LjIyIDE3LjE5IDhaTTEwIDE2SDE0VjE0SDEwVjE2Wk0xMCAxMkgxNFYxMEgxMFYxMloiIGZpbGw9IiM2MTYxNjEiLz4KICAgICAgICA8cGF0aCBkPSJNMjIgMTguNUMyMiAyMC40MzMgMjAuNDMzIDIyIDE4LjUgMjJDMTYuNTY3IDIyIDE1IDIwLjQzMyAxNSAxOC41QzE1IDE2LjU2NyAxNi41NjcgMTUgMTguNSAxNUMyMC40MzMgMTUgMjIgMTYuNTY3IDIyIDE4LjVaIiBmaWxsPSIjNjE2MTYxIi8+CiAgICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-bug: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIj4KICAgIDxwYXRoIGQ9Ik0yMCA4aC0yLjgxYy0uNDUtLjc4LTEuMDctMS40NS0xLjgyLTEuOTZMMTcgNC40MSAxNS41OSAzbC0yLjE3IDIuMTdDMTIuOTYgNS4wNiAxMi40OSA1IDEyIDVjLS40OSAwLS45Ni4wNi0xLjQxLjE3TDguNDEgMyA3IDQuNDFsMS42MiAxLjYzQzcuODggNi41NSA3LjI2IDcuMjIgNi44MSA4SDR2MmgyLjA5Yy0uMDUuMzMtLjA5LjY2LS4wOSAxdjFINHYyaDJ2MWMwIC4zNC4wNC42Ny4wOSAxSDR2MmgyLjgxYzEuMDQgMS43OSAyLjk3IDMgNS4xOSAzczQuMTUtMS4yMSA1LjE5LTNIMjB2LTJoLTIuMDljLjA1LS4zMy4wOS0uNjYuMDktMXYtMWgydi0yaC0ydi0xYzAtLjM0LS4wNC0uNjctLjA5LTFIMjBWOHptLTYgOGgtNHYtMmg0djJ6bTAtNGgtNHYtMmg0djJ6Ii8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-build: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTE0LjkgMTcuNDVDMTYuMjUgMTcuNDUgMTcuMzUgMTYuMzUgMTcuMzUgMTVDMTcuMzUgMTMuNjUgMTYuMjUgMTIuNTUgMTQuOSAxMi41NUMxMy41NCAxMi41NSAxMi40NSAxMy42NSAxMi40NSAxNUMxMi40NSAxNi4zNSAxMy41NCAxNy40NSAxNC45IDE3LjQ1Wk0yMC4xIDE1LjY4TDIxLjU4IDE2Ljg0QzIxLjcxIDE2Ljk1IDIxLjc1IDE3LjEzIDIxLjY2IDE3LjI5TDIwLjI2IDE5LjcxQzIwLjE3IDE5Ljg2IDIwIDE5LjkyIDE5LjgzIDE5Ljg2TDE4LjA5IDE5LjE2QzE3LjczIDE5LjQ0IDE3LjMzIDE5LjY3IDE2LjkxIDE5Ljg1TDE2LjY0IDIxLjdDMTYuNjIgMjEuODcgMTYuNDcgMjIgMTYuMyAyMkgxMy41QzEzLjMyIDIyIDEzLjE4IDIxLjg3IDEzLjE1IDIxLjdMMTIuODkgMTkuODVDMTIuNDYgMTkuNjcgMTIuMDcgMTkuNDQgMTEuNzEgMTkuMTZMOS45NjAwMiAxOS44NkM5LjgxMDAyIDE5LjkyIDkuNjIwMDIgMTkuODYgOS41NDAwMiAxOS43MUw4LjE0MDAyIDE3LjI5QzguMDUwMDIgMTcuMTMgOC4wOTAwMiAxNi45NSA4LjIyMDAyIDE2Ljg0TDkuNzAwMDIgMTUuNjhMOS42NTAwMSAxNUw5LjcwMDAyIDE0LjMxTDguMjIwMDIgMTMuMTZDOC4wOTAwMiAxMy4wNSA4LjA1MDAyIDEyLjg2IDguMTQwMDIgMTIuNzFMOS41NDAwMiAxMC4yOUM5LjYyMDAyIDEwLjEzIDkuODEwMDIgMTAuMDcgOS45NjAwMiAxMC4xM0wxMS43MSAxMC44NEMxMi4wNyAxMC41NiAxMi40NiAxMC4zMiAxMi44OSAxMC4xNUwxMy4xNSA4LjI4OTk4QzEzLjE4IDguMTI5OTggMTMuMzIgNy45OTk5OCAxMy41IDcuOTk5OThIMTYuM0MxNi40NyA3Ljk5OTk4IDE2LjYyIDguMTI5OTggMTYuNjQgOC4yODk5OEwxNi45MSAxMC4xNUMxNy4zMyAxMC4zMiAxNy43MyAxMC41NiAxOC4wOSAxMC44NEwxOS44MyAxMC4xM0MyMCAxMC4wNyAyMC4xNyAxMC4xMyAyMC4yNiAxMC4yOUwyMS42NiAxMi43MUMyMS43NSAxMi44NiAyMS43MSAxMy4wNSAyMS41OCAxMy4xNkwyMC4xIDE0LjMxTDIwLjE1IDE1TDIwLjEgMTUuNjhaIi8+CiAgICA8cGF0aCBkPSJNNy4zMjk2NiA3LjQ0NDU0QzguMDgzMSA3LjAwOTU0IDguMzM5MzIgNi4wNTMzMiA3LjkwNDMyIDUuMjk5ODhDNy40NjkzMiA0LjU0NjQzIDYuNTA4MSA0LjI4MTU2IDUuNzU0NjYgNC43MTY1NkM1LjM5MTc2IDQuOTI2MDggNS4xMjY5NSA1LjI3MTE4IDUuMDE4NDkgNS42NzU5NEM0LjkxMDA0IDYuMDgwNzEgNC45NjY4MiA2LjUxMTk4IDUuMTc2MzQgNi44NzQ4OEM1LjYxMTM0IDcuNjI4MzIgNi41NzYyMiA3Ljg3OTU0IDcuMzI5NjYgNy40NDQ1NFpNOS42NTcxOCA0Ljc5NTkzTDEwLjg2NzIgNC45NTE3OUMxMC45NjI4IDQuOTc3NDEgMTEuMDQwMiA1LjA3MTMzIDExLjAzODIgNS4xODc5M0wxMS4wMzg4IDYuOTg4OTNDMTEuMDQ1NSA3LjEwMDU0IDEwLjk2MTYgNy4xOTUxOCAxMC44NTUgNy4yMTA1NEw5LjY2MDAxIDcuMzgwODNMOS4yMzkxNSA4LjEzMTg4TDkuNjY5NjEgOS4yNTc0NUM5LjcwNzI5IDkuMzYyNzEgOS42NjkzNCA5LjQ3Njk5IDkuNTc0MDggOS41MzE5OUw4LjAxNTIzIDEwLjQzMkM3LjkxMTMxIDEwLjQ5MiA3Ljc5MzM3IDEwLjQ2NzcgNy43MjEwNSAxMC4zODI0TDYuOTg3NDggOS40MzE4OEw2LjEwOTMxIDkuNDMwODNMNS4zNDcwNCAxMC4zOTA1QzUuMjg5MDkgMTAuNDcwMiA1LjE3MzgzIDEwLjQ5MDUgNS4wNzE4NyAxMC40MzM5TDMuNTEyNDUgOS41MzI5M0MzLjQxMDQ5IDkuNDc2MzMgMy4zNzY0NyA5LjM1NzQxIDMuNDEwNzUgOS4yNTY3OUwzLjg2MzQ3IDguMTQwOTNMMy42MTc0OSA3Ljc3NDg4TDMuNDIzNDcgNy4zNzg4M0wyLjIzMDc1IDcuMjEyOTdDMi4xMjY0NyA3LjE5MjM1IDIuMDQwNDkgNy4xMDM0MiAyLjA0MjQ1IDYuOTg2ODJMMi4wNDE4NyA1LjE4NTgyQzIuMDQzODMgNS4wNjkyMiAyLjExOTA5IDQuOTc5NTggMi4yMTcwNCA0Ljk2OTIyTDMuNDIwNjUgNC43OTM5M0wzLjg2NzQ5IDQuMDI3ODhMMy40MTEwNSAyLjkxNzMxQzMuMzczMzcgMi44MTIwNCAzLjQxMTMxIDIuNjk3NzYgMy41MTUyMyAyLjYzNzc2TDUuMDc0MDggMS43Mzc3NkM1LjE2OTM0IDEuNjgyNzYgNS4yODcyOSAxLjcwNzA0IDUuMzU5NjEgMS43OTIzMUw2LjExOTE1IDIuNzI3ODhMNi45ODAwMSAyLjczODkzTDcuNzI0OTYgMS43ODkyMkM3Ljc5MTU2IDEuNzA0NTggNy45MTU0OCAxLjY3OTIyIDguMDA4NzkgMS43NDA4Mkw5LjU2ODIxIDIuNjQxODJDOS42NzAxNyAyLjY5ODQyIDkuNzEyODUgMi44MTIzNCA5LjY4NzIzIDIuOTA3OTdMOS4yMTcxOCA0LjAzMzgzTDkuNDYzMTYgNC4zOTk4OEw5LjY1NzE4IDQuNzk1OTNaIi8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-caret-down-empty-thin: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIwIDIwIj4KCTxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSIgc2hhcGUtcmVuZGVyaW5nPSJnZW9tZXRyaWNQcmVjaXNpb24iPgoJCTxwb2x5Z29uIGNsYXNzPSJzdDEiIHBvaW50cz0iOS45LDEzLjYgMy42LDcuNCA0LjQsNi42IDkuOSwxMi4yIDE1LjQsNi43IDE2LjEsNy40ICIvPgoJPC9nPgo8L3N2Zz4K);
  --jp-icon-caret-down-empty: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDE4IDE4Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiIHNoYXBlLXJlbmRlcmluZz0iZ2VvbWV0cmljUHJlY2lzaW9uIj4KICAgIDxwYXRoIGQ9Ik01LjIsNS45TDksOS43bDMuOC0zLjhsMS4yLDEuMmwtNC45LDVsLTQuOS01TDUuMiw1Ljl6Ii8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-caret-down: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDE4IDE4Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiIHNoYXBlLXJlbmRlcmluZz0iZ2VvbWV0cmljUHJlY2lzaW9uIj4KICAgIDxwYXRoIGQ9Ik01LjIsNy41TDksMTEuMmwzLjgtMy44SDUuMnoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-caret-left: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDE4IDE4Ij4KCTxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSIgc2hhcGUtcmVuZGVyaW5nPSJnZW9tZXRyaWNQcmVjaXNpb24iPgoJCTxwYXRoIGQ9Ik0xMC44LDEyLjhMNy4xLDlsMy44LTMuOGwwLDcuNkgxMC44eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-caret-right: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDE4IDE4Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiIHNoYXBlLXJlbmRlcmluZz0iZ2VvbWV0cmljUHJlY2lzaW9uIj4KICAgIDxwYXRoIGQ9Ik03LjIsNS4yTDEwLjksOWwtMy44LDMuOFY1LjJINy4yeiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-caret-up-empty-thin: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIwIDIwIj4KCTxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSIgc2hhcGUtcmVuZGVyaW5nPSJnZW9tZXRyaWNQcmVjaXNpb24iPgoJCTxwb2x5Z29uIGNsYXNzPSJzdDEiIHBvaW50cz0iMTUuNCwxMy4zIDkuOSw3LjcgNC40LDEzLjIgMy42LDEyLjUgOS45LDYuMyAxNi4xLDEyLjYgIi8+Cgk8L2c+Cjwvc3ZnPgo=);
  --jp-icon-caret-up: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDE4IDE4Ij4KCTxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSIgc2hhcGUtcmVuZGVyaW5nPSJnZW9tZXRyaWNQcmVjaXNpb24iPgoJCTxwYXRoIGQ9Ik01LjIsMTAuNUw5LDYuOGwzLjgsMy44SDUuMnoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-case-sensitive: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIwIDIwIj4KICA8ZyBjbGFzcz0ianAtaWNvbjIiIGZpbGw9IiM0MTQxNDEiPgogICAgPHJlY3QgeD0iMiIgeT0iMiIgd2lkdGg9IjE2IiBoZWlnaHQ9IjE2Ii8+CiAgPC9nPgogIDxnIGNsYXNzPSJqcC1pY29uLWFjY2VudDIiIGZpbGw9IiNGRkYiPgogICAgPHBhdGggZD0iTTcuNiw4aDAuOWwzLjUsOGgtMS4xTDEwLDE0SDZsLTAuOSwySDRMNy42LDh6IE04LDkuMUw2LjQsMTNoMy4yTDgsOS4xeiIvPgogICAgPHBhdGggZD0iTTE2LjYsOS44Yy0wLjIsMC4xLTAuNCwwLjEtMC43LDAuMWMtMC4yLDAtMC40LTAuMS0wLjYtMC4yYy0wLjEtMC4xLTAuMi0wLjQtMC4yLTAuNyBjLTAuMywwLjMtMC42LDAuNS0wLjksMC43Yy0wLjMsMC4xLTAuNywwLjItMS4xLDAuMmMtMC4zLDAtMC41LDAtMC43LTAuMWMtMC4yLTAuMS0wLjQtMC4yLTAuNi0wLjNjLTAuMi0wLjEtMC4zLTAuMy0wLjQtMC41IGMtMC4xLTAuMi0wLjEtMC40LTAuMS0wLjdjMC0wLjMsMC4xLTAuNiwwLjItMC44YzAuMS0wLjIsMC4zLTAuNCwwLjQtMC41QzEyLDcsMTIuMiw2LjksMTIuNSw2LjhjMC4yLTAuMSwwLjUtMC4xLDAuNy0wLjIgYzAuMy0wLjEsMC41LTAuMSwwLjctMC4xYzAuMiwwLDAuNC0wLjEsMC42LTAuMWMwLjIsMCwwLjMtMC4xLDAuNC0wLjJjMC4xLTAuMSwwLjItMC4yLDAuMi0wLjRjMC0xLTEuMS0xLTEuMy0xIGMtMC40LDAtMS40LDAtMS40LDEuMmgtMC45YzAtMC40LDAuMS0wLjcsMC4yLTFjMC4xLTAuMiwwLjMtMC40LDAuNS0wLjZjMC4yLTAuMiwwLjUtMC4zLDAuOC0wLjNDMTMuMyw0LDEzLjYsNCwxMy45LDQgYzAuMywwLDAuNSwwLDAuOCwwLjFjMC4zLDAsMC41LDAuMSwwLjcsMC4yYzAuMiwwLjEsMC40LDAuMywwLjUsMC41QzE2LDUsMTYsNS4yLDE2LDUuNnYyLjljMCwwLjIsMCwwLjQsMCwwLjUgYzAsMC4xLDAuMSwwLjIsMC4zLDAuMmMwLjEsMCwwLjIsMCwwLjMsMFY5Ljh6IE0xNS4yLDYuOWMtMS4yLDAuNi0zLjEsMC4yLTMuMSwxLjRjMCwxLjQsMy4xLDEsMy4xLTAuNVY2Ljl6Ii8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-check: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIj4KICAgIDxwYXRoIGQ9Ik05IDE2LjE3TDQuODMgMTJsLTEuNDIgMS40MUw5IDE5IDIxIDdsLTEuNDEtMS40MXoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-circle-empty: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTEyIDJDNi40NyAyIDIgNi40NyAyIDEyczQuNDcgMTAgMTAgMTAgMTAtNC40NyAxMC0xMFMxNy41MyAyIDEyIDJ6bTAgMThjLTQuNDEgMC04LTMuNTktOC04czMuNTktOCA4LTggOCAzLjU5IDggOC0zLjU5IDgtOCA4eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-circle: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMTggMTgiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPGNpcmNsZSBjeD0iOSIgY3k9IjkiIHI9IjgiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-clear: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8bWFzayBpZD0iZG9udXRIb2xlIj4KICAgIDxyZWN0IHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgZmlsbD0id2hpdGUiIC8+CiAgICA8Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSI4IiBmaWxsPSJibGFjayIvPgogIDwvbWFzaz4KCiAgPGcgY2xhc3M9ImpwLWljb24zIiBmaWxsPSIjNjE2MTYxIj4KICAgIDxyZWN0IGhlaWdodD0iMTgiIHdpZHRoPSIyIiB4PSIxMSIgeT0iMyIgdHJhbnNmb3JtPSJyb3RhdGUoMzE1LCAxMiwgMTIpIi8+CiAgICA8Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMCIgbWFzaz0idXJsKCNkb251dEhvbGUpIi8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-close: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbi1ub25lIGpwLWljb24tc2VsZWN0YWJsZS1pbnZlcnNlIGpwLWljb24zLWhvdmVyIiBmaWxsPSJub25lIj4KICAgIDxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjExIi8+CiAgPC9nPgoKICA8ZyBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIGpwLWljb24tYWNjZW50Mi1ob3ZlciIgZmlsbD0iIzYxNjE2MSI+CiAgICA8cGF0aCBkPSJNMTkgNi40MUwxNy41OSA1IDEyIDEwLjU5IDYuNDEgNSA1IDYuNDEgMTAuNTkgMTIgNSAxNy41OSA2LjQxIDE5IDEyIDEzLjQxIDE3LjU5IDE5IDE5IDE3LjU5IDEzLjQxIDEyeiIvPgogIDwvZz4KCiAgPGcgY2xhc3M9ImpwLWljb24tbm9uZSBqcC1pY29uLWJ1c3kiIGZpbGw9Im5vbmUiPgogICAgPGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iNyIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-code-check: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIiBzaGFwZS1yZW5kZXJpbmc9Imdlb21ldHJpY1ByZWNpc2lvbiI+CiAgICA8cGF0aCBkPSJNNi41OSwzLjQxTDIsOEw2LjU5LDEyLjZMOCwxMS4xOEw0LjgyLDhMOCw0LjgyTDYuNTksMy40MU0xMi40MSwzLjQxTDExLDQuODJMMTQuMTgsOEwxMSwxMS4xOEwxMi40MSwxMi42TDE3LDhMMTIuNDEsMy40MU0yMS41OSwxMS41OUwxMy41LDE5LjY4TDkuODMsMTZMOC40MiwxNy40MUwxMy41LDIyLjVMMjMsMTNMMjEuNTksMTEuNTlaIiAvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-code: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjIiIHZpZXdCb3g9IjAgMCAyOCAyOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KCTxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CgkJPHBhdGggZD0iTTExLjQgMTguNkw2LjggMTRMMTEuNCA5LjRMMTAgOEw0IDE0TDEwIDIwTDExLjQgMTguNlpNMTYuNiAxOC42TDIxLjIgMTRMMTYuNiA5LjRMMTggOEwyNCAxNEwxOCAyMEwxNi42IDE4LjZWMTguNloiLz4KCTwvZz4KPC9zdmc+Cg==);
  --jp-icon-collapse-all: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGgKICAgICAgICAgICAgZD0iTTggMmMxIDAgMTEgMCAxMiAwczIgMSAyIDJjMCAxIDAgMTEgMCAxMnMwIDItMiAyQzIwIDE0IDIwIDQgMjAgNFMxMCA0IDYgNGMwLTIgMS0yIDItMnoiIC8+CiAgICAgICAgPHBhdGgKICAgICAgICAgICAgZD0iTTE4IDhjMC0xLTEtMi0yLTJTNSA2IDQgNnMtMiAxLTIgMmMwIDEgMCAxMSAwIDEyczEgMiAyIDJjMSAwIDExIDAgMTIgMHMyLTEgMi0yYzAtMSAwLTExIDAtMTJ6bS0yIDB2MTJINFY4eiIgLz4KICAgICAgICA8cGF0aCBkPSJNNiAxM3YyaDh2LTJ6IiAvPgogICAgPC9nPgo8L3N2Zz4K);
  --jp-icon-console: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIwMCAyMDAiPgogIDxnIGNsYXNzPSJqcC1jb25zb2xlLWljb24tYmFja2dyb3VuZC1jb2xvciBqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiMwMjg4RDEiPgogICAgPHBhdGggZD0iTTIwIDE5LjhoMTYwdjE1OS45SDIweiIvPgogIDwvZz4KICA8ZyBjbGFzcz0ianAtY29uc29sZS1pY29uLWNvbG9yIGpwLWljb24tc2VsZWN0YWJsZS1pbnZlcnNlIiBmaWxsPSIjZmZmIj4KICAgIDxwYXRoIGQ9Ik0xMDUgMTI3LjNoNDB2MTIuOGgtNDB6TTUxLjEgNzdMNzQgOTkuOWwtMjMuMyAyMy4zIDEwLjUgMTAuNSAyMy4zLTIzLjNMOTUgOTkuOSA4NC41IDg5LjQgNjEuNiA2Ni41eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-copy: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMTggMTgiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTExLjksMUgzLjJDMi40LDEsMS43LDEuNywxLjcsMi41djEwLjJoMS41VjIuNWg4LjdWMXogTTE0LjEsMy45aC04Yy0wLjgsMC0xLjUsMC43LTEuNSwxLjV2MTAuMmMwLDAuOCwwLjcsMS41LDEuNSwxLjVoOCBjMC44LDAsMS41LTAuNywxLjUtMS41VjUuNEMxNS41LDQuNiwxNC45LDMuOSwxNC4xLDMuOXogTTE0LjEsMTUuNWgtOFY1LjRoOFYxNS41eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-copyright: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDI0IDI0IiBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCI+CiAgPGcgY2xhc3M9ImpwLWljb24zIiBmaWxsPSIjNjE2MTYxIj4KICAgIDxwYXRoIGQ9Ik0xMS44OCw5LjE0YzEuMjgsMC4wNiwxLjYxLDEuMTUsMS42MywxLjY2aDEuNzljLTAuMDgtMS45OC0xLjQ5LTMuMTktMy40NS0zLjE5QzkuNjQsNy42MSw4LDksOCwxMi4xNCBjMCwxLjk0LDAuOTMsNC4yNCwzLjg0LDQuMjRjMi4yMiwwLDMuNDEtMS42NSwzLjQ0LTIuOTVoLTEuNzljLTAuMDMsMC41OS0wLjQ1LDEuMzgtMS42MywxLjQ0QzEwLjU1LDE0LjgzLDEwLDEzLjgxLDEwLDEyLjE0IEMxMCw5LjI1LDExLjI4LDkuMTYsMTEuODgsOS4xNHogTTEyLDJDNi40OCwyLDIsNi40OCwyLDEyczQuNDgsMTAsMTAsMTBzMTAtNC40OCwxMC0xMFMxNy41MiwyLDEyLDJ6IE0xMiwyMGMtNC40MSwwLTgtMy41OS04LTggczMuNTktOCw4LThzOCwzLjU5LDgsOFMxNi40MSwyMCwxMiwyMHoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-cut: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTkuNjQgNy42NGMuMjMtLjUuMzYtMS4wNS4zNi0xLjY0IDAtMi4yMS0xLjc5LTQtNC00UzIgMy43OSAyIDZzMS43OSA0IDQgNGMuNTkgMCAxLjE0LS4xMyAxLjY0LS4zNkwxMCAxMmwtMi4zNiAyLjM2QzcuMTQgMTQuMTMgNi41OSAxNCA2IDE0Yy0yLjIxIDAtNCAxLjc5LTQgNHMxLjc5IDQgNCA0IDQtMS43OSA0LTRjMC0uNTktLjEzLTEuMTQtLjM2LTEuNjRMMTIgMTRsNyA3aDN2LTFMOS42NCA3LjY0ek02IDhjLTEuMSAwLTItLjg5LTItMnMuOS0yIDItMiAyIC44OSAyIDItLjkgMi0yIDJ6bTAgMTJjLTEuMSAwLTItLjg5LTItMnMuOS0yIDItMiAyIC44OSAyIDItLjkgMi0yIDJ6bTYtNy41Yy0uMjggMC0uNS0uMjItLjUtLjVzLjIyLS41LjUtLjUuNS4yMi41LjUtLjIyLjUtLjUuNXpNMTkgM2wtNiA2IDIgMiA3LTdWM3oiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-delete: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCI+CiAgICA8cGF0aCBkPSJNMCAwaDI0djI0SDB6IiBmaWxsPSJub25lIiAvPgogICAgPHBhdGggY2xhc3M9ImpwLWljb24zIiBmaWxsPSIjNjI2MjYyIiBkPSJNNiAxOWMwIDEuMS45IDIgMiAyaDhjMS4xIDAgMi0uOSAyLTJWN0g2djEyek0xOSA0aC0zLjVsLTEtMWgtNWwtMSAxSDV2MmgxNFY0eiIgLz4KPC9zdmc+Cg==);
  --jp-icon-download: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTE5IDloLTRWM0g5djZINWw3IDcgNy03ek01IDE4djJoMTR2LTJINXoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-duplicate: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iMTQiIHZpZXdCb3g9IjAgMCAxNCAxNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggY2xhc3M9ImpwLWljb24zIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTIuNzk5OTggMC44NzVIOC44OTU4MkM5LjIwMDYxIDAuODc1IDkuNDQ5OTggMS4xMzkxNCA5LjQ0OTk4IDEuNDYxOThDOS40NDk5OCAxLjc4NDgyIDkuMjAwNjEgMi4wNDg5NiA4Ljg5NTgyIDIuMDQ4OTZIMy4zNTQxNUMzLjA0OTM2IDIuMDQ4OTYgMi43OTk5OCAyLjMxMzEgMi43OTk5OCAyLjYzNTk0VjkuNjc5NjlDMi43OTk5OCAxMC4wMDI1IDIuNTUwNjEgMTAuMjY2NyAyLjI0NTgyIDEwLjI2NjdDMS45NDEwMyAxMC4yNjY3IDEuNjkxNjUgMTAuMDAyNSAxLjY5MTY1IDkuNjc5NjlWMi4wNDg5NkMxLjY5MTY1IDEuNDAzMjggMi4xOTA0IDAuODc1IDIuNzk5OTggMC44NzVaTTUuMzY2NjUgMTEuOVY0LjU1SDExLjA4MzNWMTEuOUg1LjM2NjY1Wk00LjE0MTY1IDQuMTQxNjdDNC4xNDE2NSAzLjY5MDYzIDQuNTA3MjggMy4zMjUgNC45NTgzMiAzLjMyNUgxMS40OTE3QzExLjk0MjcgMy4zMjUgMTIuMzA4MyAzLjY5MDYzIDEyLjMwODMgNC4xNDE2N1YxMi4zMDgzQzEyLjMwODMgMTIuNzU5NCAxMS45NDI3IDEzLjEyNSAxMS40OTE3IDEzLjEyNUg0Ljk1ODMyQzQuNTA3MjggMTMuMTI1IDQuMTQxNjUgMTIuNzU5NCA0LjE0MTY1IDEyLjMwODNWNC4xNDE2N1oiIGZpbGw9IiM2MTYxNjEiLz4KPHBhdGggY2xhc3M9ImpwLWljb24zIiBkPSJNOS40MzU3NCA4LjI2NTA3SDguMzY0MzFWOS4zMzY1QzguMzY0MzEgOS40NTQzNSA4LjI2Nzg4IDkuNTUwNzggOC4xNTAwMiA5LjU1MDc4QzguMDMyMTcgOS41NTA3OCA3LjkzNTc0IDkuNDU0MzUgNy45MzU3NCA5LjMzNjVWOC4yNjUwN0g2Ljg2NDMxQzYuNzQ2NDUgOC4yNjUwNyA2LjY1MDAyIDguMTY4NjQgNi42NTAwMiA4LjA1MDc4QzYuNjUwMDIgNy45MzI5MiA2Ljc0NjQ1IDcuODM2NSA2Ljg2NDMxIDcuODM2NUg3LjkzNTc0VjYuNzY1MDdDNy45MzU3NCA2LjY0NzIxIDguMDMyMTcgNi41NTA3OCA4LjE1MDAyIDYuNTUwNzhDOC4yNjc4OCA2LjU1MDc4IDguMzY0MzEgNi42NDcyMSA4LjM2NDMxIDYuNzY1MDdWNy44MzY1SDkuNDM1NzRDOS41NTM2IDcuODM2NSA5LjY1MDAyIDcuOTMyOTIgOS42NTAwMiA4LjA1MDc4QzkuNjUwMDIgOC4xNjg2NCA5LjU1MzYgOC4yNjUwNyA5LjQzNTc0IDguMjY1MDdaIiBmaWxsPSIjNjE2MTYxIiBzdHJva2U9IiM2MTYxNjEiIHN0cm9rZS13aWR0aD0iMC41Ii8+Cjwvc3ZnPgo=);
  --jp-icon-edit: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTMgMTcuMjVWMjFoMy43NUwxNy44MSA5Ljk0bC0zLjc1LTMuNzVMMyAxNy4yNXpNMjAuNzEgNy4wNGMuMzktLjM5LjM5LTEuMDIgMC0xLjQxbC0yLjM0LTIuMzRjLS4zOS0uMzktMS4wMi0uMzktMS40MSAwbC0xLjgzIDEuODMgMy43NSAzLjc1IDEuODMtMS44M3oiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-ellipses: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPGNpcmNsZSBjeD0iNSIgY3k9IjEyIiByPSIyIi8+CiAgICA8Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIyIi8+CiAgICA8Y2lyY2xlIGN4PSIxOSIgY3k9IjEyIiByPSIyIi8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-error: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KPGcgY2xhc3M9ImpwLWljb24zIiBmaWxsPSIjNjE2MTYxIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjE5IiByPSIyIi8+PHBhdGggZD0iTTEwIDNoNHYxMmgtNHoiLz48L2c+CjxwYXRoIGZpbGw9Im5vbmUiIGQ9Ik0wIDBoMjR2MjRIMHoiLz4KPC9zdmc+Cg==);
  --jp-icon-expand-all: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGgKICAgICAgICAgICAgZD0iTTggMmMxIDAgMTEgMCAxMiAwczIgMSAyIDJjMCAxIDAgMTEgMCAxMnMwIDItMiAyQzIwIDE0IDIwIDQgMjAgNFMxMCA0IDYgNGMwLTIgMS0yIDItMnoiIC8+CiAgICAgICAgPHBhdGgKICAgICAgICAgICAgZD0iTTE4IDhjMC0xLTEtMi0yLTJTNSA2IDQgNnMtMiAxLTIgMmMwIDEgMCAxMSAwIDEyczEgMiAyIDJjMSAwIDExIDAgMTIgMHMyLTEgMi0yYzAtMSAwLTExIDAtMTJ6bS0yIDB2MTJINFY4eiIgLz4KICAgICAgICA8cGF0aCBkPSJNMTEgMTBIOXYzSDZ2MmgzdjNoMnYtM2gzdi0yaC0zeiIgLz4KICAgIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-extension: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTIwLjUgMTFIMTlWN2MwLTEuMS0uOS0yLTItMmgtNFYzLjVDMTMgMi4xMiAxMS44OCAxIDEwLjUgMVM4IDIuMTIgOCAzLjVWNUg0Yy0xLjEgMC0xLjk5LjktMS45OSAydjMuOEgzLjVjMS40OSAwIDIuNyAxLjIxIDIuNyAyLjdzLTEuMjEgMi43LTIuNyAyLjdIMlYyMGMwIDEuMS45IDIgMiAyaDMuOHYtMS41YzAtMS40OSAxLjIxLTIuNyAyLjctMi43IDEuNDkgMCAyLjcgMS4yMSAyLjcgMi43VjIySDE3YzEuMSAwIDItLjkgMi0ydi00aDEuNWMxLjM4IDAgMi41LTEuMTIgMi41LTIuNVMyMS44OCAxMSAyMC41IDExeiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-fast-forward: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTQgMThsOC41LTZMNCA2djEyem05LTEydjEybDguNS02TDEzIDZ6Ii8+CiAgICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-file-upload: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTkgMTZoNnYtNmg0bC03LTctNyA3aDR6bS00IDJoMTR2Mkg1eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-file: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8cGF0aCBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIiBkPSJNMTkuMyA4LjJsLTUuNS01LjVjLS4zLS4zLS43LS41LTEuMi0uNUgzLjljLS44LjEtMS42LjktMS42IDEuOHYxNC4xYzAgLjkuNyAxLjYgMS42IDEuNmgxNC4yYy45IDAgMS42LS43IDEuNi0xLjZWOS40Yy4xLS41LS4xLS45LS40LTEuMnptLTUuOC0zLjNsMy40IDMuNmgtMy40VjQuOXptMy45IDEyLjdINC43Yy0uMSAwLS4yIDAtLjItLjJWNC43YzAtLjIuMS0uMy4yLS4zaDcuMnY0LjRzMCAuOC4zIDEuMWMuMy4zIDEuMS4zIDEuMS4zaDQuM3Y3LjJzLS4xLjItLjIuMnoiLz4KPC9zdmc+Cg==);
  --jp-icon-filter-dot: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiNGRkYiPgogICAgPHBhdGggZD0iTTE0LDEyVjE5Ljg4QzE0LjA0LDIwLjE4IDEzLjk0LDIwLjUgMTMuNzEsMjAuNzFDMTMuMzIsMjEuMSAxMi42OSwyMS4xIDEyLjMsMjAuNzFMMTAuMjksMTguN0MxMC4wNiwxOC40NyA5Ljk2LDE4LjE2IDEwLDE3Ljg3VjEySDkuOTdMNC4yMSw0LjYyQzMuODcsNC4xOSAzLjk1LDMuNTYgNC4zOCwzLjIyQzQuNTcsMy4wOCA0Ljc4LDMgNSwzVjNIMTlWM0MxOS4yMiwzIDE5LjQzLDMuMDggMTkuNjIsMy4yMkMyMC4wNSwzLjU2IDIwLjEzLDQuMTkgMTkuNzksNC42MkwxNC4wMywxMkgxNFoiIC8+CiAgPC9nPgogIDxnIGNsYXNzPSJqcC1pY29uLWRvdCIgZmlsbD0iI0ZGRiI+CiAgICA8Y2lyY2xlIGN4PSIxOCIgY3k9IjE3IiByPSIzIj48L2NpcmNsZT4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-filter-list: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTEwIDE4aDR2LTJoLTR2MnpNMyA2djJoMThWNkgzem0zIDdoMTJ2LTJINnYyeiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-filter: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiNGRkYiPgogICAgPHBhdGggZD0iTTE0LDEyVjE5Ljg4QzE0LjA0LDIwLjE4IDEzLjk0LDIwLjUgMTMuNzEsMjAuNzFDMTMuMzIsMjEuMSAxMi42OSwyMS4xIDEyLjMsMjAuNzFMMTAuMjksMTguN0MxMC4wNiwxOC40NyA5Ljk2LDE4LjE2IDEwLDE3Ljg3VjEySDkuOTdMNC4yMSw0LjYyQzMuODcsNC4xOSAzLjk1LDMuNTYgNC4zOCwzLjIyQzQuNTcsMy4wOCA0Ljc4LDMgNSwzVjNIMTlWM0MxOS4yMiwzIDE5LjQzLDMuMDggMTkuNjIsMy4yMkMyMC4wNSwzLjU2IDIwLjEzLDQuMTkgMTkuNzksNC42MkwxNC4wMywxMkgxNFoiIC8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-folder-favorite: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDI0IDI0IiB3aWR0aD0iMjRweCIgZmlsbD0iIzAwMDAwMCI+CiAgPHBhdGggZD0iTTAgMGgyNHYyNEgwVjB6IiBmaWxsPSJub25lIi8+PHBhdGggY2xhc3M9ImpwLWljb24zIGpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iIzYxNjE2MSIgZD0iTTIwIDZoLThsLTItMkg0Yy0xLjEgMC0yIC45LTIgMnYxMmMwIDEuMS45IDIgMiAyaDE2YzEuMSAwIDItLjkgMi0yVjhjMC0xLjEtLjktMi0yLTJ6bS0yLjA2IDExTDE1IDE1LjI4IDEyLjA2IDE3bC43OC0zLjMzLTIuNTktMi4yNCAzLjQxLS4yOUwxNSA4bDEuMzQgMy4xNCAzLjQxLjI5LTIuNTkgMi4yNC43OCAzLjMzeiIvPgo8L3N2Zz4K);
  --jp-icon-folder: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8cGF0aCBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIiBkPSJNMTAgNEg0Yy0xLjEgMC0xLjk5LjktMS45OSAyTDIgMThjMCAxLjEuOSAyIDIgMmgxNmMxLjEgMCAyLS45IDItMlY4YzAtMS4xLS45LTItMi0yaC04bC0yLTJ6Ii8+Cjwvc3ZnPgo=);
  --jp-icon-home: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDI0IDI0IiB3aWR0aD0iMjRweCIgZmlsbD0iIzAwMDAwMCI+CiAgPHBhdGggZD0iTTAgMGgyNHYyNEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGNsYXNzPSJqcC1pY29uMyBqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiM2MTYxNjEiIGQ9Ik0xMCAyMHYtNmg0djZoNXYtOGgzTDEyIDMgMiAxMmgzdjh6Ii8+Cjwvc3ZnPgo=);
  --jp-icon-html5: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDUxMiA1MTIiPgogIDxwYXRoIGNsYXNzPSJqcC1pY29uMCBqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiMwMDAiIGQ9Ik0xMDguNCAwaDIzdjIyLjhoMjEuMlYwaDIzdjY5aC0yM1Y0NmgtMjF2MjNoLTIzLjJNMjA2IDIzaC0yMC4zVjBoNjMuN3YyM0gyMjl2NDZoLTIzbTUzLjUtNjloMjQuMWwxNC44IDI0LjNMMzEzLjIgMGgyNC4xdjY5aC0yM1YzNC44bC0xNi4xIDI0LjgtMTYuMS0yNC44VjY5aC0yMi42bTg5LjItNjloMjN2NDYuMmgzMi42VjY5aC01NS42Ii8+CiAgPHBhdGggY2xhc3M9ImpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iI2U0NGQyNiIgZD0iTTEwNy42IDQ3MWwtMzMtMzcwLjRoMzYyLjhsLTMzIDM3MC4yTDI1NS43IDUxMiIvPgogIDxwYXRoIGNsYXNzPSJqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiNmMTY1MjkiIGQ9Ik0yNTYgNDgwLjVWMTMxaDE0OC4zTDM3NiA0NDciLz4KICA8cGF0aCBjbGFzcz0ianAtaWNvbi1zZWxlY3RhYmxlLWludmVyc2UiIGZpbGw9IiNlYmViZWIiIGQ9Ik0xNDIgMTc2LjNoMTE0djQ1LjRoLTY0LjJsNC4yIDQ2LjVoNjB2NDUuM0gxNTQuNG0yIDIyLjhIMjAybDMuMiAzNi4zIDUwLjggMTMuNnY0Ny40bC05My4yLTI2Ii8+CiAgPHBhdGggY2xhc3M9ImpwLWljb24tc2VsZWN0YWJsZS1pbnZlcnNlIiBmaWxsPSIjZmZmIiBkPSJNMzY5LjYgMTc2LjNIMjU1Ljh2NDUuNGgxMDkuNm0tNC4xIDQ2LjVIMjU1Ljh2NDUuNGg1NmwtNS4zIDU5LTUwLjcgMTMuNnY0Ny4ybDkzLTI1LjgiLz4KPC9zdmc+Cg==);
  --jp-icon-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8cGF0aCBjbGFzcz0ianAtaWNvbi1icmFuZDQganAtaWNvbi1zZWxlY3RhYmxlLWludmVyc2UiIGZpbGw9IiNGRkYiIGQ9Ik0yLjIgMi4yaDE3LjV2MTcuNUgyLjJ6Ii8+CiAgPHBhdGggY2xhc3M9ImpwLWljb24tYnJhbmQwIGpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iIzNGNTFCNSIgZD0iTTIuMiAyLjJ2MTcuNWgxNy41bC4xLTE3LjVIMi4yem0xMi4xIDIuMmMxLjIgMCAyLjIgMSAyLjIgMi4ycy0xIDIuMi0yLjIgMi4yLTIuMi0xLTIuMi0yLjIgMS0yLjIgMi4yLTIuMnpNNC40IDE3LjZsMy4zLTguOCAzLjMgNi42IDIuMi0zLjIgNC40IDUuNEg0LjR6Ii8+Cjwvc3ZnPgo=);
  --jp-icon-info: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDUwLjk3OCA1MC45NzgiPgoJPGcgY2xhc3M9ImpwLWljb24zIiBmaWxsPSIjNjE2MTYxIj4KCQk8cGF0aCBkPSJNNDMuNTIsNy40NThDMzguNzExLDIuNjQ4LDMyLjMwNywwLDI1LjQ4OSwwQzE4LjY3LDAsMTIuMjY2LDIuNjQ4LDcuNDU4LDcuNDU4CgkJCWMtOS45NDMsOS45NDEtOS45NDMsMjYuMTE5LDAsMzYuMDYyYzQuODA5LDQuODA5LDExLjIxMiw3LjQ1NiwxOC4wMzEsNy40NThjMCwwLDAuMDAxLDAsMC4wMDIsMAoJCQljNi44MTYsMCwxMy4yMjEtMi42NDgsMTguMDI5LTcuNDU4YzQuODA5LTQuODA5LDcuNDU3LTExLjIxMiw3LjQ1Ny0xOC4wM0M1MC45NzcsMTguNjcsNDguMzI4LDEyLjI2Niw0My41Miw3LjQ1OHoKCQkJIE00Mi4xMDYsNDIuMTA1Yy00LjQzMiw0LjQzMS0xMC4zMzIsNi44NzItMTYuNjE1LDYuODcyaC0wLjAwMmMtNi4yODUtMC4wMDEtMTIuMTg3LTIuNDQxLTE2LjYxNy02Ljg3MgoJCQljLTkuMTYyLTkuMTYzLTkuMTYyLTI0LjA3MSwwLTMzLjIzM0MxMy4zMDMsNC40NCwxOS4yMDQsMiwyNS40ODksMmM2LjI4NCwwLDEyLjE4NiwyLjQ0LDE2LjYxNyw2Ljg3MgoJCQljNC40MzEsNC40MzEsNi44NzEsMTAuMzMyLDYuODcxLDE2LjYxN0M0OC45NzcsMzEuNzcyLDQ2LjUzNiwzNy42NzUsNDIuMTA2LDQyLjEwNXoiLz4KCQk8cGF0aCBkPSJNMjMuNTc4LDMyLjIxOGMtMC4wMjMtMS43MzQsMC4xNDMtMy4wNTksMC40OTYtMy45NzJjMC4zNTMtMC45MTMsMS4xMS0xLjk5NywyLjI3Mi0zLjI1MwoJCQljMC40NjgtMC41MzYsMC45MjMtMS4wNjIsMS4zNjctMS41NzVjMC42MjYtMC43NTMsMS4xMDQtMS40NzgsMS40MzYtMi4xNzVjMC4zMzEtMC43MDcsMC40OTUtMS41NDEsMC40OTUtMi41CgkJCWMwLTEuMDk2LTAuMjYtMi4wODgtMC43NzktMi45NzljLTAuNTY1LTAuODc5LTEuNTAxLTEuMzM2LTIuODA2LTEuMzY5Yy0xLjgwMiwwLjA1Ny0yLjk4NSwwLjY2Ny0zLjU1LDEuODMyCgkJCWMtMC4zMDEsMC41MzUtMC41MDMsMS4xNDEtMC42MDcsMS44MTRjLTAuMTM5LDAuNzA3LTAuMjA3LDEuNDMyLTAuMjA3LDIuMTc0aC0yLjkzN2MtMC4wOTEtMi4yMDgsMC40MDctNC4xMTQsMS40OTMtNS43MTkKCQkJYzEuMDYyLTEuNjQsMi44NTUtMi40ODEsNS4zNzgtMi41MjdjMi4xNiwwLjAyMywzLjg3NCwwLjYwOCw1LjE0MSwxLjc1OGMxLjI3OCwxLjE2LDEuOTI5LDIuNzY0LDEuOTUsNC44MTEKCQkJYzAsMS4xNDItMC4xMzcsMi4xMTEtMC40MSwyLjkxMWMtMC4zMDksMC44NDUtMC43MzEsMS41OTMtMS4yNjgsMi4yNDNjLTAuNDkyLDAuNjUtMS4wNjgsMS4zMTgtMS43MywyLjAwMgoJCQljLTAuNjUsMC42OTctMS4zMTMsMS40NzktMS45ODcsMi4zNDZjLTAuMjM5LDAuMzc3LTAuNDI5LDAuNzc3LTAuNTY1LDEuMTk5Yy0wLjE2LDAuOTU5LTAuMjE3LDEuOTUxLTAuMTcxLDIuOTc5CgkJCUMyNi41ODksMzIuMjE4LDIzLjU3OCwzMi4yMTgsMjMuNTc4LDMyLjIxOHogTTIzLjU3OCwzOC4yMnYtMy40ODRoMy4wNzZ2My40ODRIMjMuNTc4eiIvPgoJPC9nPgo8L3N2Zz4K);
  --jp-icon-inspector: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8cGF0aCBjbGFzcz0ianAtaW5zcGVjdG9yLWljb24tY29sb3IganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIiBkPSJNMjAgNEg0Yy0xLjEgMC0xLjk5LjktMS45OSAyTDIgMThjMCAxLjEuOSAyIDIgMmgxNmMxLjEgMCAyLS45IDItMlY2YzAtMS4xLS45LTItMi0yem0tNSAxNEg0di00aDExdjR6bTAtNUg0VjloMTF2NHptNSA1aC00VjloNHY5eiIvPgo8L3N2Zz4K);
  --jp-icon-json: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8ZyBjbGFzcz0ianAtanNvbi1pY29uLWNvbG9yIGpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iI0Y5QTgyNSI+CiAgICA8cGF0aCBkPSJNMjAuMiAxMS44Yy0xLjYgMC0xLjcuNS0xLjcgMSAwIC40LjEuOS4xIDEuMy4xLjUuMS45LjEgMS4zIDAgMS43LTEuNCAyLjMtMy41IDIuM2gtLjl2LTEuOWguNWMxLjEgMCAxLjQgMCAxLjQtLjggMC0uMyAwLS42LS4xLTEgMC0uNC0uMS0uOC0uMS0xLjIgMC0xLjMgMC0xLjggMS4zLTItMS4zLS4yLTEuMy0uNy0xLjMtMiAwLS40LjEtLjguMS0xLjIuMS0uNC4xLS43LjEtMSAwLS44LS40LS43LTEuNC0uOGgtLjVWNC4xaC45YzIuMiAwIDMuNS43IDMuNSAyLjMgMCAuNC0uMS45LS4xIDEuMy0uMS41LS4xLjktLjEgMS4zIDAgLjUuMiAxIDEuNyAxdjEuOHpNMS44IDEwLjFjMS42IDAgMS43LS41IDEuNy0xIDAtLjQtLjEtLjktLjEtMS4zLS4xLS41LS4xLS45LS4xLTEuMyAwLTEuNiAxLjQtMi4zIDMuNS0yLjNoLjl2MS45aC0uNWMtMSAwLTEuNCAwLTEuNC44IDAgLjMgMCAuNi4xIDEgMCAuMi4xLjYuMSAxIDAgMS4zIDAgMS44LTEuMyAyQzYgMTEuMiA2IDExLjcgNiAxM2MwIC40LS4xLjgtLjEgMS4yLS4xLjMtLjEuNy0uMSAxIDAgLjguMy44IDEuNC44aC41djEuOWgtLjljLTIuMSAwLTMuNS0uNi0zLjUtMi4zIDAtLjQuMS0uOS4xLTEuMy4xLS41LjEtLjkuMS0xLjMgMC0uNS0uMi0xLTEuNy0xdi0xLjl6Ii8+CiAgICA8Y2lyY2xlIGN4PSIxMSIgY3k9IjEzLjgiIHI9IjIuMSIvPgogICAgPGNpcmNsZSBjeD0iMTEiIGN5PSI4LjIiIHI9IjIuMSIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-julia: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDMyNSAzMDAiPgogIDxnIGNsYXNzPSJqcC1icmFuZDAganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjY2IzYzMzIj4KICAgIDxwYXRoIGQ9Ik0gMTUwLjg5ODQzOCAyMjUgQyAxNTAuODk4NDM4IDI2Ni40MjE4NzUgMTE3LjMyMDMxMiAzMDAgNzUuODk4NDM4IDMwMCBDIDM0LjQ3NjU2MiAzMDAgMC44OTg0MzggMjY2LjQyMTg3NSAwLjg5ODQzOCAyMjUgQyAwLjg5ODQzOCAxODMuNTc4MTI1IDM0LjQ3NjU2MiAxNTAgNzUuODk4NDM4IDE1MCBDIDExNy4zMjAzMTIgMTUwIDE1MC44OTg0MzggMTgzLjU3ODEyNSAxNTAuODk4NDM4IDIyNSIvPgogIDwvZz4KICA8ZyBjbGFzcz0ianAtYnJhbmQwIGpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iIzM4OTgyNiI+CiAgICA8cGF0aCBkPSJNIDIzNy41IDc1IEMgMjM3LjUgMTE2LjQyMTg3NSAyMDMuOTIxODc1IDE1MCAxNjIuNSAxNTAgQyAxMjEuMDc4MTI1IDE1MCA4Ny41IDExNi40MjE4NzUgODcuNSA3NSBDIDg3LjUgMzMuNTc4MTI1IDEyMS4wNzgxMjUgMCAxNjIuNSAwIEMgMjAzLjkyMTg3NSAwIDIzNy41IDMzLjU3ODEyNSAyMzcuNSA3NSIvPgogIDwvZz4KICA8ZyBjbGFzcz0ianAtYnJhbmQwIGpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iIzk1NThiMiI+CiAgICA8cGF0aCBkPSJNIDMyNC4xMDE1NjIgMjI1IEMgMzI0LjEwMTU2MiAyNjYuNDIxODc1IDI5MC41MjM0MzggMzAwIDI0OS4xMDE1NjIgMzAwIEMgMjA3LjY3OTY4OCAzMDAgMTc0LjEwMTU2MiAyNjYuNDIxODc1IDE3NC4xMDE1NjIgMjI1IEMgMTc0LjEwMTU2MiAxODMuNTc4MTI1IDIwNy42Nzk2ODggMTUwIDI0OS4xMDE1NjIgMTUwIEMgMjkwLjUyMzQzOCAxNTAgMzI0LjEwMTU2MiAxODMuNTc4MTI1IDMyNC4xMDE1NjIgMjI1Ii8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-jupyter-favicon: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUyIiBoZWlnaHQ9IjE2NSIgdmlld0JveD0iMCAwIDE1MiAxNjUiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgPGcgY2xhc3M9ImpwLWp1cHl0ZXItaWNvbi1jb2xvciIgZmlsbD0iI0YzNzcyNiI+CiAgICA8cGF0aCB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjA3ODk0NywgMTEwLjU4MjkyNykiIGQ9Ik03NS45NDIyODQyLDI5LjU4MDQ1NjEgQzQzLjMwMjM5NDcsMjkuNTgwNDU2MSAxNC43OTY3ODMyLDE3LjY1MzQ2MzQgMCwwIEM1LjUxMDgzMjExLDE1Ljg0MDY4MjkgMTUuNzgxNTM4OSwyOS41NjY3NzMyIDI5LjM5MDQ5NDcsMzkuMjc4NDE3MSBDNDIuOTk5Nyw0OC45ODk4NTM3IDU5LjI3MzcsNTQuMjA2NzgwNSA3NS45NjA1Nzg5LDU0LjIwNjc4MDUgQzkyLjY0NzQ1NzksNTQuMjA2NzgwNSAxMDguOTIxNDU4LDQ4Ljk4OTg1MzcgMTIyLjUzMDY2MywzOS4yNzg0MTcxIEMxMzYuMTM5NDUzLDI5LjU2Njc3MzIgMTQ2LjQxMDI4NCwxNS44NDA2ODI5IDE1MS45MjExNTgsMCBDMTM3LjA4Nzg2OCwxNy42NTM0NjM0IDEwOC41ODI1ODksMjkuNTgwNDU2MSA3NS45NDIyODQyLDI5LjU4MDQ1NjEgTDc1Ljk0MjI4NDIsMjkuNTgwNDU2MSBaIiAvPgogICAgPHBhdGggdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMzczNjgsIDAuNzA0ODc4KSIgZD0iTTc1Ljk3ODQ1NzksMjQuNjI2NDA3MyBDMTA4LjYxODc2MywyNC42MjY0MDczIDEzNy4xMjQ0NTgsMzYuNTUzNDQxNSAxNTEuOTIxMTU4LDU0LjIwNjc4MDUgQzE0Ni40MTAyODQsMzguMzY2MjIyIDEzNi4xMzk0NTMsMjQuNjQwMTMxNyAxMjIuNTMwNjYzLDE0LjkyODQ4NzggQzEwOC45MjE0NTgsNS4yMTY4NDM5IDkyLjY0NzQ1NzksMCA3NS45NjA1Nzg5LDAgQzU5LjI3MzcsMCA0Mi45OTk3LDUuMjE2ODQzOSAyOS4zOTA0OTQ3LDE0LjkyODQ4NzggQzE1Ljc4MTUzODksMjQuNjQwMTMxNyA1LjUxMDgzMjExLDM4LjM2NjIyMiAwLDU0LjIwNjc4MDUgQzE0LjgzMzA4MTYsMzYuNTg5OTI5MyA0My4zMzg1Njg0LDI0LjYyNjQwNzMgNzUuOTc4NDU3OSwyNC42MjY0MDczIEw3NS45Nzg0NTc5LDI0LjYyNjQwNzMgWiIgLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-jupyter: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzkiIGhlaWdodD0iNTEiIHZpZXdCb3g9IjAgMCAzOSA1MSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTYzOCAtMjI4MSkiPgogICAgIDxnIGNsYXNzPSJqcC1qdXB5dGVyLWljb24tY29sb3IiIGZpbGw9IiNGMzc3MjYiPgogICAgICA8cGF0aCB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxNjM5Ljc0IDIzMTEuOTgpIiBkPSJNIDE4LjI2NDYgNy4xMzQxMUMgMTAuNDE0NSA3LjEzNDExIDMuNTU4NzIgNC4yNTc2IDAgMEMgMS4zMjUzOSAzLjgyMDQgMy43OTU1NiA3LjEzMDgxIDcuMDY4NiA5LjQ3MzAzQyAxMC4zNDE3IDExLjgxNTIgMTQuMjU1NyAxMy4wNzM0IDE4LjI2OSAxMy4wNzM0QyAyMi4yODIzIDEzLjA3MzQgMjYuMTk2MyAxMS44MTUyIDI5LjQ2OTQgOS40NzMwM0MgMzIuNzQyNCA3LjEzMDgxIDM1LjIxMjYgMy44MjA0IDM2LjUzOCAwQyAzMi45NzA1IDQuMjU3NiAyNi4xMTQ4IDcuMTM0MTEgMTguMjY0NiA3LjEzNDExWiIvPgogICAgICA8cGF0aCB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxNjM5LjczIDIyODUuNDgpIiBkPSJNIDE4LjI3MzMgNS45MzkzMUMgMjYuMTIzNSA1LjkzOTMxIDMyLjk3OTMgOC44MTU4MyAzNi41MzggMTMuMDczNEMgMzUuMjEyNiA5LjI1MzAzIDMyLjc0MjQgNS45NDI2MiAyOS40Njk0IDMuNjAwNEMgMjYuMTk2MyAxLjI1ODE4IDIyLjI4MjMgMCAxOC4yNjkgMEMgMTQuMjU1NyAwIDEwLjM0MTcgMS4yNTgxOCA3LjA2ODYgMy42MDA0QyAzLjc5NTU2IDUuOTQyNjIgMS4zMjUzOSA5LjI1MzAzIDAgMTMuMDczNEMgMy41Njc0NSA4LjgyNDYzIDEwLjQyMzIgNS45MzkzMSAxOC4yNzMzIDUuOTM5MzFaIi8+CiAgICA8L2c+CiAgICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgICA8cGF0aCB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxNjY5LjMgMjI4MS4zMSkiIGQ9Ik0gNS44OTM1MyAyLjg0NEMgNS45MTg4OSAzLjQzMTY1IDUuNzcwODUgNC4wMTM2NyA1LjQ2ODE1IDQuNTE2NDVDIDUuMTY1NDUgNS4wMTkyMiA0LjcyMTY4IDUuNDIwMTUgNC4xOTI5OSA1LjY2ODUxQyAzLjY2NDMgNS45MTY4OCAzLjA3NDQ0IDYuMDAxNTEgMi40OTgwNSA1LjkxMTcxQyAxLjkyMTY2IDUuODIxOSAxLjM4NDYzIDUuNTYxNyAwLjk1NDg5OCA1LjE2NDAxQyAwLjUyNTE3IDQuNzY2MzMgMC4yMjIwNTYgNC4yNDkwMyAwLjA4MzkwMzcgMy42Nzc1N0MgLTAuMDU0MjQ4MyAzLjEwNjExIC0wLjAyMTIzIDIuNTA2MTcgMC4xNzg3ODEgMS45NTM2NEMgMC4zNzg3OTMgMS40MDExIDAuNzM2ODA5IDAuOTIwODE3IDEuMjA3NTQgMC41NzM1MzhDIDEuNjc4MjYgMC4yMjYyNTkgMi4yNDA1NSAwLjAyNzU5MTkgMi44MjMyNiAwLjAwMjY3MjI5QyAzLjYwMzg5IC0wLjAzMDcxMTUgNC4zNjU3MyAwLjI0OTc4OSA0Ljk0MTQyIDAuNzgyNTUxQyA1LjUxNzExIDEuMzE1MzEgNS44NTk1NiAyLjA1Njc2IDUuODkzNTMgMi44NDRaIi8+CiAgICAgIDxwYXRoIHRyYW5zZm9ybT0idHJhbnNsYXRlKDE2MzkuOCAyMzIzLjgxKSIgZD0iTSA3LjQyNzg5IDMuNTgzMzhDIDcuNDYwMDggNC4zMjQzIDcuMjczNTUgNS4wNTgxOSA2Ljg5MTkzIDUuNjkyMTNDIDYuNTEwMzEgNi4zMjYwNyA1Ljk1MDc1IDYuODMxNTYgNS4yODQxMSA3LjE0NDZDIDQuNjE3NDcgNy40NTc2MyAzLjg3MzcxIDcuNTY0MTQgMy4xNDcwMiA3LjQ1MDYzQyAyLjQyMDMyIDcuMzM3MTIgMS43NDMzNiA3LjAwODcgMS4yMDE4NCA2LjUwNjk1QyAwLjY2MDMyOCA2LjAwNTIgMC4yNzg2MSA1LjM1MjY4IDAuMTA1MDE3IDQuNjMyMDJDIC0wLjA2ODU3NTcgMy45MTEzNSAtMC4wMjYyMzYxIDMuMTU0OTQgMC4yMjY2NzUgMi40NTg1NkMgMC40Nzk1ODcgMS43NjIxNyAwLjkzMTY5NyAxLjE1NzEzIDEuNTI1NzYgMC43MjAwMzNDIDIuMTE5ODMgMC4yODI5MzUgMi44MjkxNCAwLjAzMzQzOTUgMy41NjM4OSAwLjAwMzEzMzQ0QyA0LjU0NjY3IC0wLjAzNzQwMzMgNS41MDUyOSAwLjMxNjcwNiA2LjIyOTYxIDAuOTg3ODM1QyA2Ljk1MzkzIDEuNjU4OTYgNy4zODQ4NCAyLjU5MjM1IDcuNDI3ODkgMy41ODMzOEwgNy40Mjc4OSAzLjU4MzM4WiIvPgogICAgICA8cGF0aCB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxNjM4LjM2IDIyODYuMDYpIiBkPSJNIDIuMjc0NzEgNC4zOTYyOUMgMS44NDM2MyA0LjQxNTA4IDEuNDE2NzEgNC4zMDQ0NSAxLjA0Nzk5IDQuMDc4NDNDIDAuNjc5MjY4IDMuODUyNCAwLjM4NTMyOCAzLjUyMTE0IDAuMjAzMzcxIDMuMTI2NTZDIDAuMDIxNDEzNiAyLjczMTk4IC0wLjA0MDM3OTggMi4yOTE4MyAwLjAyNTgxMTYgMS44NjE4MUMgMC4wOTIwMDMxIDEuNDMxOCAwLjI4MzIwNCAxLjAzMTI2IDAuNTc1MjEzIDAuNzEwODgzQyAwLjg2NzIyMiAwLjM5MDUxIDEuMjQ2OTEgMC4xNjQ3MDggMS42NjYyMiAwLjA2MjA1OTJDIDIuMDg1NTMgLTAuMDQwNTg5NyAyLjUyNTYxIC0wLjAxNTQ3MTQgMi45MzA3NiAwLjEzNDIzNUMgMy4zMzU5MSAwLjI4Mzk0MSAzLjY4NzkyIDAuNTUxNTA1IDMuOTQyMjIgMC45MDMwNkMgNC4xOTY1MiAxLjI1NDYyIDQuMzQxNjkgMS42NzQzNiA0LjM1OTM1IDIuMTA5MTZDIDQuMzgyOTkgMi42OTEwNyA0LjE3Njc4IDMuMjU4NjkgMy43ODU5NyAzLjY4NzQ2QyAzLjM5NTE2IDQuMTE2MjQgMi44NTE2NiA0LjM3MTE2IDIuMjc0NzEgNC4zOTYyOUwgMi4yNzQ3MSA0LjM5NjI5WiIvPgogICAgPC9nPgogIDwvZz4+Cjwvc3ZnPgo=);
  --jp-icon-jupyterlab-wordmark: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMDAiIHZpZXdCb3g9IjAgMCAxODYwLjggNDc1Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjIiIGZpbGw9IiM0RTRFNEUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDQ4MC4xMzY0MDEsIDY0LjI3MTQ5MykiPgogICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsIDU4Ljg3NTU2NikiPgogICAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjA4NzYwMywgMC4xNDAyOTQpIj4KICAgICAgICA8cGF0aCBkPSJNLTQyNi45LDE2OS44YzAsNDguNy0zLjcsNjQuNy0xMy42LDc2LjRjLTEwLjgsMTAtMjUsMTUuNS0zOS43LDE1LjVsMy43LDI5IGMyMi44LDAuMyw0NC44LTcuOSw2MS45LTIzLjFjMTcuOC0xOC41LDI0LTQ0LjEsMjQtODMuM1YwSC00Mjd2MTcwLjFMLTQyNi45LDE2OS44TC00MjYuOSwxNjkuOHoiLz4KICAgICAgPC9nPgogICAgPC9nPgogICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTU1LjA0NTI5NiwgNTYuODM3MTA0KSI+CiAgICAgIDxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEuNTYyNDUzLCAxLjc5OTg0MikiPgogICAgICAgIDxwYXRoIGQ9Ik0tMzEyLDE0OGMwLDIxLDAsMzkuNSwxLjcsNTUuNGgtMzEuOGwtMi4xLTMzLjNoLTAuOGMtNi43LDExLjYtMTYuNCwyMS4zLTI4LDI3LjkgYy0xMS42LDYuNi0yNC44LDEwLTM4LjIsOS44Yy0zMS40LDAtNjktMTcuNy02OS04OVYwaDM2LjR2MTEyLjdjMCwzOC43LDExLjYsNjQuNyw0NC42LDY0LjdjMTAuMy0wLjIsMjAuNC0zLjUsMjguOS05LjQgYzguNS01LjksMTUuMS0xNC4zLDE4LjktMjMuOWMyLjItNi4xLDMuMy0xMi41LDMuMy0xOC45VjAuMmgzNi40VjE0OEgtMzEyTC0zMTIsMTQ4eiIvPgogICAgICA8L2c+CiAgICA8L2c+CiAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzOTAuMDEzMzIyLCA1My40Nzk2MzgpIj4KICAgICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS43MDY0NTgsIDAuMjMxNDI1KSI+CiAgICAgICAgPHBhdGggZD0iTS00NzguNiw3MS40YzAtMjYtMC44LTQ3LTEuNy02Ni43aDMyLjdsMS43LDM0LjhoMC44YzcuMS0xMi41LDE3LjUtMjIuOCwzMC4xLTI5LjcgYzEyLjUtNywyNi43LTEwLjMsNDEtOS44YzQ4LjMsMCw4NC43LDQxLjcsODQuNywxMDMuM2MwLDczLjEtNDMuNywxMDkuMi05MSwxMDkuMmMtMTIuMSwwLjUtMjQuMi0yLjItMzUtNy44IGMtMTAuOC01LjYtMTkuOS0xMy45LTI2LjYtMjQuMmgtMC44VjI5MWgtMzZ2LTIyMEwtNDc4LjYsNzEuNEwtNDc4LjYsNzEuNHogTS00NDIuNiwxMjUuNmMwLjEsNS4xLDAuNiwxMC4xLDEuNywxNS4xIGMzLDEyLjMsOS45LDIzLjMsMTkuOCwzMS4xYzkuOSw3LjgsMjIuMSwxMi4xLDM0LjcsMTIuMWMzOC41LDAsNjAuNy0zMS45LDYwLjctNzguNWMwLTQwLjctMjEuMS03NS42LTU5LjUtNzUuNiBjLTEyLjksMC40LTI1LjMsNS4xLTM1LjMsMTMuNGMtOS45LDguMy0xNi45LDE5LjctMTkuNiwzMi40Yy0xLjUsNC45LTIuMywxMC0yLjUsMTUuMVYxMjUuNkwtNDQyLjYsMTI1LjZMLTQ0Mi42LDEyNS42eiIvPgogICAgICA8L2c+CiAgICA8L2c+CiAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg2MDYuNzQwNzI2LCA1Ni44MzcxMDQpIj4KICAgICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC43NTEyMjYsIDEuOTg5Mjk5KSI+CiAgICAgICAgPHBhdGggZD0iTS00NDAuOCwwbDQzLjcsMTIwLjFjNC41LDEzLjQsOS41LDI5LjQsMTIuOCw0MS43aDAuOGMzLjctMTIuMiw3LjktMjcuNywxMi44LTQyLjQgbDM5LjctMTE5LjJoMzguNUwtMzQ2LjksMTQ1Yy0yNiw2OS43LTQzLjcsMTA1LjQtNjguNiwxMjcuMmMtMTIuNSwxMS43LTI3LjksMjAtNDQuNiwyMy45bC05LjEtMzEuMSBjMTEuNy0zLjksMjIuNS0xMC4xLDMxLjgtMTguMWMxMy4yLTExLjEsMjMuNy0yNS4yLDMwLjYtNDEuMmMxLjUtMi44LDIuNS01LjcsMi45LTguOGMtMC4zLTMuMy0xLjItNi42LTIuNS05LjdMLTQ4MC4yLDAuMSBoMzkuN0wtNDQwLjgsMEwtNDQwLjgsMHoiLz4KICAgICAgPC9nPgogICAgPC9nPgogICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoODIyLjc0ODEwNCwgMC4wMDAwMDApIj4KICAgICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS40NjQwNTAsIDAuMzc4OTE0KSI+CiAgICAgICAgPHBhdGggZD0iTS00MTMuNywwdjU4LjNoNTJ2MjguMmgtNTJWMTk2YzAsMjUsNywzOS41LDI3LjMsMzkuNWM3LjEsMC4xLDE0LjItMC43LDIxLjEtMi41IGwxLjcsMjcuN2MtMTAuMywzLjctMjEuMyw1LjQtMzIuMiw1Yy03LjMsMC40LTE0LjYtMC43LTIxLjMtMy40Yy02LjgtMi43LTEyLjktNi44LTE3LjktMTIuMWMtMTAuMy0xMC45LTE0LjEtMjktMTQuMS01Mi45IFY4Ni41aC0zMVY1OC4zaDMxVjkuNkwtNDEzLjcsMEwtNDEzLjcsMHoiLz4KICAgICAgPC9nPgogICAgPC9nPgogICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoOTc0LjQzMzI4NiwgNTMuNDc5NjM4KSI+CiAgICAgIDxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuOTkwMDM0LCAwLjYxMDMzOSkiPgogICAgICAgIDxwYXRoIGQ9Ik0tNDQ1LjgsMTEzYzAuOCw1MCwzMi4yLDcwLjYsNjguNiw3MC42YzE5LDAuNiwzNy45LTMsNTUuMy0xMC41bDYuMiwyNi40IGMtMjAuOSw4LjktNDMuNSwxMy4xLTY2LjIsMTIuNmMtNjEuNSwwLTk4LjMtNDEuMi05OC4zLTEwMi41Qy00ODAuMiw0OC4yLTQ0NC43LDAtMzg2LjUsMGM2NS4yLDAsODIuNyw1OC4zLDgyLjcsOTUuNyBjLTAuMSw1LjgtMC41LDExLjUtMS4yLDE3LjJoLTE0MC42SC00NDUuOEwtNDQ1LjgsMTEzeiBNLTMzOS4yLDg2LjZjMC40LTIzLjUtOS41LTYwLjEtNTAuNC02MC4xIGMtMzYuOCwwLTUyLjgsMzQuNC01NS43LDYwLjFILTMzOS4yTC0zMzkuMiw4Ni42TC0zMzkuMiw4Ni42eiIvPgogICAgICA8L2c+CiAgICA8L2c+CiAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjAxLjk2MTA1OCwgNTMuNDc5NjM4KSI+CiAgICAgIDxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEuMTc5NjQwLCAwLjcwNTA2OCkiPgogICAgICAgIDxwYXRoIGQ9Ik0tNDc4LjYsNjhjMC0yMy45LTAuNC00NC41LTEuNy02My40aDMxLjhsMS4yLDM5LjloMS43YzkuMS0yNy4zLDMxLTQ0LjUsNTUuMy00NC41IGMzLjUtMC4xLDcsMC40LDEwLjMsMS4ydjM0LjhjLTQuMS0wLjktOC4yLTEuMy0xMi40LTEuMmMtMjUuNiwwLTQzLjcsMTkuNy00OC43LDQ3LjRjLTEsNS43LTEuNiwxMS41LTEuNywxNy4ydjEwOC4zaC0zNlY2OCBMLTQ3OC42LDY4eiIvPgogICAgICA8L2c+CiAgICA8L2c+CiAgPC9nPgoKICA8ZyBjbGFzcz0ianAtaWNvbi13YXJuMCIgZmlsbD0iI0YzNzcyNiI+CiAgICA8cGF0aCBkPSJNMTM1Mi4zLDMyNi4yaDM3VjI4aC0zN1YzMjYuMnogTTE2MDQuOCwzMjYuMmMtMi41LTEzLjktMy40LTMxLjEtMy40LTQ4Ljd2LTc2IGMwLTQwLjctMTUuMS04My4xLTc3LjMtODMuMWMtMjUuNiwwLTUwLDcuMS02Ni44LDE4LjFsOC40LDI0LjRjMTQuMy05LjIsMzQtMTUuMSw1My0xNS4xYzQxLjYsMCw0Ni4yLDMwLjIsNDYuMiw0N3Y0LjIgYy03OC42LTAuNC0xMjIuMywyNi41LTEyMi4zLDc1LjZjMCwyOS40LDIxLDU4LjQsNjIuMiw1OC40YzI5LDAsNTAuOS0xNC4zLDYyLjItMzAuMmgxLjNsMi45LDI1LjZIMTYwNC44eiBNMTU2NS43LDI1Ny43IGMwLDMuOC0wLjgsOC0yLjEsMTEuOGMtNS45LDE3LjItMjIuNywzNC00OS4yLDM0Yy0xOC45LDAtMzQuOS0xMS4zLTM0LjktMzUuM2MwLTM5LjUsNDUuOC00Ni42LDg2LjItNDUuOFYyNTcuN3ogTTE2OTguNSwzMjYuMiBsMS43LTMzLjZoMS4zYzE1LjEsMjYuOSwzOC43LDM4LjIsNjguMSwzOC4yYzQ1LjQsMCw5MS4yLTM2LjEsOTEuMi0xMDguOGMwLjQtNjEuNy0zNS4zLTEwMy43LTg1LjctMTAzLjcgYy0zMi44LDAtNTYuMywxNC43LTY5LjMsMzcuNGgtMC44VjI4aC0zNi42djI0NS43YzAsMTguMS0wLjgsMzguNi0xLjcsNTIuNUgxNjk4LjV6IE0xNzA0LjgsMjA4LjJjMC01LjksMS4zLTEwLjksMi4xLTE1LjEgYzcuNi0yOC4xLDMxLjEtNDUuNCw1Ni4zLTQ1LjRjMzkuNSwwLDYwLjUsMzQuOSw2MC41LDc1LjZjMCw0Ni42LTIzLjEsNzguMS02MS44LDc4LjFjLTI2LjksMC00OC4zLTE3LjYtNTUuNS00My4zIGMtMC44LTQuMi0xLjctOC44LTEuNy0xMy40VjIwOC4yeiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-kernel: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICAgIDxwYXRoIGNsYXNzPSJqcC1pY29uMiIgZmlsbD0iIzYxNjE2MSIgZD0iTTE1IDlIOXY2aDZWOXptLTIgNGgtMnYtMmgydjJ6bTgtMlY5aC0yVjdjMC0xLjEtLjktMi0yLTJoLTJWM2gtMnYyaC0yVjNIOXYySDdjLTEuMSAwLTIgLjktMiAydjJIM3YyaDJ2MkgzdjJoMnYyYzAgMS4xLjkgMiAyIDJoMnYyaDJ2LTJoMnYyaDJ2LTJoMmMxLjEgMCAyLS45IDItMnYtMmgydi0yaC0ydi0yaDJ6bS00IDZIN1Y3aDEwdjEweiIvPgo8L3N2Zz4K);
  --jp-icon-keyboard: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8cGF0aCBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIiBkPSJNMjAgNUg0Yy0xLjEgMC0xLjk5LjktMS45OSAyTDIgMTdjMCAxLjEuOSAyIDIgMmgxNmMxLjEgMCAyLS45IDItMlY3YzAtMS4xLS45LTItMi0yem0tOSAzaDJ2MmgtMlY4em0wIDNoMnYyaC0ydi0yek04IDhoMnYySDhWOHptMCAzaDJ2Mkg4di0yem0tMSAySDV2LTJoMnYyem0wLTNINVY4aDJ2MnptOSA3SDh2LTJoOHYyem0wLTRoLTJ2LTJoMnYyem0wLTNoLTJWOGgydjJ6bTMgM2gtMnYtMmgydjJ6bTAtM2gtMlY4aDJ2MnoiLz4KPC9zdmc+Cg==);
  --jp-icon-launch: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMzIgMzIiIHdpZHRoPSIzMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIj4KICAgIDxwYXRoIGQ9Ik0yNiwyOEg2YTIuMDAyNywyLjAwMjcsMCwwLDEtMi0yVjZBMi4wMDI3LDIuMDAyNywwLDAsMSw2LDRIMTZWNkg2VjI2SDI2VjE2aDJWMjZBMi4wMDI3LDIuMDAyNywwLDAsMSwyNiwyOFoiLz4KICAgIDxwb2x5Z29uIHBvaW50cz0iMjAgMiAyMCA0IDI2LjU4NiA0IDE4IDEyLjU4NiAxOS40MTQgMTQgMjggNS40MTQgMjggMTIgMzAgMTIgMzAgMiAyMCAyIi8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-launcher: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8cGF0aCBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIiBkPSJNMTkgMTlINVY1aDdWM0g1YTIgMiAwIDAwLTIgMnYxNGEyIDIgMCAwMDIgMmgxNGMxLjEgMCAyLS45IDItMnYtN2gtMnY3ek0xNCAzdjJoMy41OWwtOS44MyA5LjgzIDEuNDEgMS40MUwxOSA2LjQxVjEwaDJWM2gtN3oiLz4KPC9zdmc+Cg==);
  --jp-icon-line-form: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICAgIDxwYXRoIGZpbGw9IndoaXRlIiBkPSJNNS44OCA0LjEyTDEzLjc2IDEybC03Ljg4IDcuODhMOCAyMmwxMC0xMEw4IDJ6Ii8+Cjwvc3ZnPgo=);
  --jp-icon-link: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTMuOSAxMmMwLTEuNzEgMS4zOS0zLjEgMy4xLTMuMWg0VjdIN2MtMi43NiAwLTUgMi4yNC01IDVzMi4yNCA1IDUgNWg0di0xLjlIN2MtMS43MSAwLTMuMS0xLjM5LTMuMS0zLjF6TTggMTNoOHYtMkg4djJ6bTktNmgtNHYxLjloNGMxLjcxIDAgMy4xIDEuMzkgMy4xIDMuMXMtMS4zOSAzLjEtMy4xIDMuMWgtNFYxN2g0YzIuNzYgMCA1LTIuMjQgNS01cy0yLjI0LTUtNS01eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-list: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICAgIDxwYXRoIGNsYXNzPSJqcC1pY29uMiBqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiM2MTYxNjEiIGQ9Ik0xOSA1djE0SDVWNWgxNG0xLjEtMkgzLjljLS41IDAtLjkuNC0uOS45djE2LjJjMCAuNC40LjkuOS45aDE2LjJjLjQgMCAuOS0uNS45LS45VjMuOWMwLS41LS41LS45LS45LS45ek0xMSA3aDZ2MmgtNlY3em0wIDRoNnYyaC02di0yem0wIDRoNnYyaC02ek03IDdoMnYySDd6bTAgNGgydjJIN3ptMCA0aDJ2Mkg3eiIvPgo8L3N2Zz4K);
  --jp-icon-markdown: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8cGF0aCBjbGFzcz0ianAtaWNvbi1jb250cmFzdDAganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjN0IxRkEyIiBkPSJNNSAxNC45aDEybC02LjEgNnptOS40LTYuOGMwLTEuMy0uMS0yLjktLjEtNC41LS40IDEuNC0uOSAyLjktMS4zIDQuM2wtMS4zIDQuM2gtMkw4LjUgNy45Yy0uNC0xLjMtLjctMi45LTEtNC4zLS4xIDEuNi0uMSAzLjItLjIgNC42TDcgMTIuNEg0LjhsLjctMTFoMy4zTDEwIDVjLjQgMS4yLjcgMi43IDEgMy45LjMtMS4yLjctMi42IDEtMy45bDEuMi0zLjdoMy4zbC42IDExaC0yLjRsLS4zLTQuMnoiLz4KPC9zdmc+Cg==);
  --jp-icon-move-down: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iMTQiIHZpZXdCb3g9IjAgMCAxNCAxNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggY2xhc3M9ImpwLWljb24zIiBkPSJNMTIuNDcxIDcuNTI4OTlDMTIuNzYzMiA3LjIzNjg0IDEyLjc2MzIgNi43NjMxNiAxMi40NzEgNi40NzEwMVY2LjQ3MTAxQzEyLjE3OSA2LjE3OTA1IDExLjcwNTcgNi4xNzg4NCAxMS40MTM1IDYuNDcwNTRMNy43NSAxMC4xMjc1VjEuNzVDNy43NSAxLjMzNTc5IDcuNDE0MjEgMSA3IDFWMUM2LjU4NTc5IDEgNi4yNSAxLjMzNTc5IDYuMjUgMS43NVYxMC4xMjc1TDIuNTk3MjYgNi40NjgyMkMyLjMwMzM4IDYuMTczODEgMS44MjY0MSA2LjE3MzU5IDEuNTMyMjYgNi40Njc3NFY2LjQ2Nzc0QzEuMjM4MyA2Ljc2MTcgMS4yMzgzIDcuMjM4MyAxLjUzMjI2IDcuNTMyMjZMNi4yOTI4OSAxMi4yOTI5QzYuNjgzNDIgMTIuNjgzNCA3LjMxNjU4IDEyLjY4MzQgNy43MDcxMSAxMi4yOTI5TDEyLjQ3MSA3LjUyODk5WiIgZmlsbD0iIzYxNjE2MSIvPgo8L3N2Zz4K);
  --jp-icon-move-up: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iMTQiIHZpZXdCb3g9IjAgMCAxNCAxNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggY2xhc3M9ImpwLWljb24zIiBkPSJNMS41Mjg5OSA2LjQ3MTAxQzEuMjM2ODQgNi43NjMxNiAxLjIzNjg0IDcuMjM2ODQgMS41Mjg5OSA3LjUyODk5VjcuNTI4OTlDMS44MjA5NSA3LjgyMDk1IDIuMjk0MjYgNy44MjExNiAyLjU4NjQ5IDcuNTI5NDZMNi4yNSAzLjg3MjVWMTIuMjVDNi4yNSAxMi42NjQyIDYuNTg1NzkgMTMgNyAxM1YxM0M3LjQxNDIxIDEzIDcuNzUgMTIuNjY0MiA3Ljc1IDEyLjI1VjMuODcyNUwxMS40MDI3IDcuNTMxNzhDMTEuNjk2NiA3LjgyNjE5IDEyLjE3MzYgNy44MjY0MSAxMi40Njc3IDcuNTMyMjZWNy41MzIyNkMxMi43NjE3IDcuMjM4MyAxMi43NjE3IDYuNzYxNyAxMi40Njc3IDYuNDY3NzRMNy43MDcxMSAxLjcwNzExQzcuMzE2NTggMS4zMTY1OCA2LjY4MzQyIDEuMzE2NTggNi4yOTI4OSAxLjcwNzExTDEuNTI4OTkgNi40NzEwMVoiIGZpbGw9IiM2MTYxNjEiLz4KPC9zdmc+Cg==);
  --jp-icon-new-folder: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTIwIDZoLThsLTItMkg0Yy0xLjExIDAtMS45OS44OS0xLjk5IDJMMiAxOGMwIDEuMTEuODkgMiAyIDJoMTZjMS4xMSAwIDItLjg5IDItMlY4YzAtMS4xMS0uODktMi0yLTJ6bS0xIDhoLTN2M2gtMnYtM2gtM3YtMmgzVjloMnYzaDN2MnoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-not-trusted: url(data:image/svg+xml;base64,PHN2ZyBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI1IDI1Ij4KICAgIDxwYXRoIGNsYXNzPSJqcC1pY29uMiIgc3Ryb2tlPSIjMzMzMzMzIiBzdHJva2Utd2lkdGg9IjIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMgMykiIGQ9Ik0xLjg2MDk0IDExLjQ0MDlDMC44MjY0NDggOC43NzAyNyAwLjg2Mzc3OSA2LjA1NzY0IDEuMjQ5MDcgNC4xOTkzMkMyLjQ4MjA2IDMuOTMzNDcgNC4wODA2OCAzLjQwMzQ3IDUuNjAxMDIgMi44NDQ5QzcuMjM1NDkgMi4yNDQ0IDguODU2NjYgMS41ODE1IDkuOTg3NiAxLjA5NTM5QzExLjA1OTcgMS41ODM0MSAxMi42MDk0IDIuMjQ0NCAxNC4yMTggMi44NDMzOUMxNS43NTAzIDMuNDEzOTQgMTcuMzk5NSAzLjk1MjU4IDE4Ljc1MzkgNC4yMTM4NUMxOS4xMzY0IDYuMDcxNzcgMTkuMTcwOSA4Ljc3NzIyIDE4LjEzOSAxMS40NDA5QzE3LjAzMDMgMTQuMzAzMiAxNC42NjY4IDE3LjE4NDQgOS45OTk5OSAxOC45MzU0QzUuMzMzMTkgMTcuMTg0NCAyLjk2OTY4IDE0LjMwMzIgMS44NjA5NCAxMS40NDA5WiIvPgogICAgPHBhdGggY2xhc3M9ImpwLWljb24yIiBzdHJva2U9IiMzMzMzMzMiIHN0cm9rZS13aWR0aD0iMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoOS4zMTU5MiA5LjMyMDMxKSIgZD0iTTcuMzY4NDIgMEwwIDcuMzY0NzkiLz4KICAgIDxwYXRoIGNsYXNzPSJqcC1pY29uMiIgc3Ryb2tlPSIjMzMzMzMzIiBzdHJva2Utd2lkdGg9IjIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDkuMzE1OTIgMTYuNjgzNikgc2NhbGUoMSAtMSkiIGQ9Ik03LjM2ODQyIDBMMCA3LjM2NDc5Ii8+Cjwvc3ZnPgo=);
  --jp-icon-notebook: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8ZyBjbGFzcz0ianAtbm90ZWJvb2staWNvbi1jb2xvciBqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiNFRjZDMDAiPgogICAgPHBhdGggZD0iTTE4LjcgMy4zdjE1LjRIMy4zVjMuM2gxNS40bTEuNS0xLjVIMS44djE4LjNoMTguM2wuMS0xOC4zeiIvPgogICAgPHBhdGggZD0iTTE2LjUgMTYuNWwtNS40LTQuMy01LjYgNC4zdi0xMWgxMXoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-numbering: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjIiIHZpZXdCb3g9IjAgMCAyOCAyOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KCTxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CgkJPHBhdGggZD0iTTQgMTlINlYxOS41SDVWMjAuNUg2VjIxSDRWMjJIN1YxOEg0VjE5Wk01IDEwSDZWNkg0VjdINVYxMFpNNCAxM0g1LjhMNCAxNS4xVjE2SDdWMTVINS4yTDcgMTIuOVYxMkg0VjEzWk05IDdWOUgyM1Y3SDlaTTkgMjFIMjNWMTlIOVYyMVpNOSAxNUgyM1YxM0g5VjE1WiIvPgoJPC9nPgo8L3N2Zz4K);
  --jp-icon-offline-bolt: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgd2lkdGg9IjE2Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTEyIDIuMDJjLTUuNTEgMC05Ljk4IDQuNDctOS45OCA5Ljk4czQuNDcgOS45OCA5Ljk4IDkuOTggOS45OC00LjQ3IDkuOTgtOS45OFMxNy41MSAyLjAyIDEyIDIuMDJ6TTExLjQ4IDIwdi02LjI2SDhMMTMgNHY2LjI2aDMuMzVMMTEuNDggMjB6Ii8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-palette: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTE4IDEzVjIwSDRWNkg5LjAyQzkuMDcgNS4yOSA5LjI0IDQuNjIgOS41IDRINEMyLjkgNCAyIDQuOSAyIDZWMjBDMiAyMS4xIDIuOSAyMiA0IDIySDE4QzE5LjEgMjIgMjAgMjEuMSAyMCAyMFYxNUwxOCAxM1pNMTkuMyA4Ljg5QzE5Ljc0IDguMTkgMjAgNy4zOCAyMCA2LjVDMjAgNC4wMSAxNy45OSAyIDE1LjUgMkMxMy4wMSAyIDExIDQuMDEgMTEgNi41QzExIDguOTkgMTMuMDEgMTEgMTUuNDkgMTFDMTYuMzcgMTEgMTcuMTkgMTAuNzQgMTcuODggMTAuM0wyMSAxMy40MkwyMi40MiAxMkwxOS4zIDguODlaTTE1LjUgOUMxNC4xMiA5IDEzIDcuODggMTMgNi41QzEzIDUuMTIgMTQuMTIgNCAxNS41IDRDMTYuODggNCAxOCA1LjEyIDE4IDYuNUMxOCA3Ljg4IDE2Ljg4IDkgMTUuNSA5WiIvPgogICAgPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik00IDZIOS4wMTg5NEM5LjAwNjM5IDYuMTY1MDIgOSA2LjMzMTc2IDkgNi41QzkgOC44MTU3NyAxMC4yMTEgMTAuODQ4NyAxMi4wMzQzIDEySDlWMTRIMTZWMTIuOTgxMUMxNi41NzAzIDEyLjkzNzcgMTcuMTIgMTIuODIwNyAxNy42Mzk2IDEyLjYzOTZMMTggMTNWMjBINFY2Wk04IDhINlYxMEg4VjhaTTYgMTJIOFYxNEg2VjEyWk04IDE2SDZWMThIOFYxNlpNOSAxNkgxNlYxOEg5VjE2WiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-paste: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTE5IDJoLTQuMThDMTQuNC44NCAxMy4zIDAgMTIgMGMtMS4zIDAtMi40Ljg0LTIuODIgMkg1Yy0xLjEgMC0yIC45LTIgMnYxNmMwIDEuMS45IDIgMiAyaDE0YzEuMSAwIDItLjkgMi0yVjRjMC0xLjEtLjktMi0yLTJ6bS03IDBjLjU1IDAgMSAuNDUgMSAxcy0uNDUgMS0xIDEtMS0uNDUtMS0xIC40NS0xIDEtMXptNyAxOEg1VjRoMnYzaDEwVjRoMnYxNnoiLz4KICAgIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-pdf: url(data:image/svg+xml;base64,PHN2ZwogICB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMiAyMiIgd2lkdGg9IjE2Ij4KICAgIDxwYXRoIHRyYW5zZm9ybT0icm90YXRlKDQ1KSIgY2xhc3M9ImpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iI0ZGMkEyQSIKICAgICAgIGQ9Im0gMjIuMzQ0MzY5LC0zLjAxNjM2NDIgaCA1LjYzODYwNCB2IDEuNTc5MjQzMyBoIC0zLjU0OTIyNyB2IDEuNTA4NjkyOTkgaCAzLjMzNzU3NiBWIDEuNjUwODE1NCBoIC0zLjMzNzU3NiB2IDMuNDM1MjYxMyBoIC0yLjA4OTM3NyB6IG0gLTcuMTM2NDQ0LDEuNTc5MjQzMyB2IDQuOTQzOTU0MyBoIDAuNzQ4OTIgcSAxLjI4MDc2MSwwIDEuOTUzNzAzLC0wLjYzNDk1MzUgMC42NzgzNjksLTAuNjM0OTUzNSAwLjY3ODM2OSwtMS44NDUxNjQxIDAsLTEuMjA0NzgzNTUgLTAuNjcyOTQyLC0xLjgzNDMxMDExIC0wLjY3Mjk0MiwtMC42Mjk1MjY1OSAtMS45NTkxMywtMC42Mjk1MjY1OSB6IG0gLTIuMDg5Mzc3LC0xLjU3OTI0MzMgaCAyLjIwMzM0MyBxIDEuODQ1MTY0LDAgMi43NDYwMzksMC4yNjU5MjA3IDAuOTA2MzAxLDAuMjYwNDkzNyAxLjU1MjEwOCwwLjg5MDAyMDMgMC41Njk4MywwLjU0ODEyMjMgMC44NDY2MDUsMS4yNjQ0ODAwNiAwLjI3Njc3NCwwLjcxNjM1NzgxIDAuMjc2Nzc0LDEuNjIyNjU4OTQgMCwwLjkxNzE1NTEgLTAuMjc2Nzc0LDEuNjM4OTM5OSAtMC4yNzY3NzUsMC43MTYzNTc4IC0wLjg0NjYwNSwxLjI2NDQ4IC0wLjY1MTIzNCwwLjYyOTUyNjYgLTEuNTYyOTYyLDAuODk1NDQ3MyAtMC45MTE3MjgsMC4yNjA0OTM3IC0yLjczNTE4NSwwLjI2MDQ5MzcgaCAtMi4yMDMzNDMgeiBtIC04LjE0NTg1NjUsMCBoIDMuNDY3ODIzIHEgMS41NDY2ODE2LDAgMi4zNzE1Nzg1LDAuNjg5MjIzIDAuODMwMzI0LDAuNjgzNzk2MSAwLjgzMDMyNCwxLjk1MzcwMzE0IDAsMS4yNzUzMzM5NyAtMC44MzAzMjQsMS45NjQ1NTcwNiBRIDkuOTg3MTk2MSwyLjI3NDkxNSA4LjQ0MDUxNDUsMi4yNzQ5MTUgSCA3LjA2MjA2ODQgViA1LjA4NjA3NjcgSCA0Ljk3MjY5MTUgWiBtIDIuMDg5Mzc2OSwxLjUxNDExOTkgdiAyLjI2MzAzOTQzIGggMS4xNTU5NDEgcSAwLjYwNzgxODgsMCAwLjkzODg2MjksLTAuMjkzMDU1NDcgMC4zMzEwNDQxLC0wLjI5ODQ4MjQxIDAuMzMxMDQ0MSwtMC44NDExNzc3MiAwLC0wLjU0MjY5NTMxIC0wLjMzMTA0NDEsLTAuODM1NzUwNzQgLTAuMzMxMDQ0MSwtMC4yOTMwNTU1IC0wLjkzODg2MjksLTAuMjkzMDU1NSB6IgovPgo8L3N2Zz4K);
  --jp-icon-python: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iLTEwIC0xMCAxMzEuMTYxMzYxNjk0MzM1OTQgMTMyLjM4ODk5OTkzODk2NDg0Ij4KICA8cGF0aCBjbGFzcz0ianAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjMzA2OTk4IiBkPSJNIDU0LjkxODc4NSw5LjE5Mjc0MjFlLTQgQyA1MC4zMzUxMzIsMC4wMjIyMTcyNyA0NS45NTc4NDYsMC40MTMxMzY5NyA0Mi4xMDYyODUsMS4wOTQ2NjkzIDMwLjc2MDA2OSwzLjA5OTE3MzEgMjguNzAwMDM2LDcuMjk0NzcxNCAyOC43MDAwMzUsMTUuMDMyMTY5IHYgMTAuMjE4NzUgaCAyNi44MTI1IHYgMy40MDYyNSBoIC0yNi44MTI1IC0xMC4wNjI1IGMgLTcuNzkyNDU5LDAgLTE0LjYxNTc1ODgsNC42ODM3MTcgLTE2Ljc0OTk5OTgsMTMuNTkzNzUgLTIuNDYxODE5OTgsMTAuMjEyOTY2IC0yLjU3MTAxNTA4LDE2LjU4NjAyMyAwLDI3LjI1IDEuOTA1OTI4Myw3LjkzNzg1MiA2LjQ1NzU0MzIsMTMuNTkzNzQ4IDE0LjI0OTk5OTgsMTMuNTkzNzUgaCA5LjIxODc1IHYgLTEyLjI1IGMgMCwtOC44NDk5MDIgNy42NTcxNDQsLTE2LjY1NjI0OCAxNi43NSwtMTYuNjU2MjUgaCAyNi43ODEyNSBjIDcuNDU0OTUxLDAgMTMuNDA2MjUzLC02LjEzODE2NCAxMy40MDYyNSwtMTMuNjI1IHYgLTI1LjUzMTI1IGMgMCwtNy4yNjYzMzg2IC02LjEyOTk4LC0xMi43MjQ3NzcxIC0xMy40MDYyNSwtMTMuOTM3NDk5NyBDIDY0LjI4MTU0OCwwLjMyNzk0Mzk3IDU5LjUwMjQzOCwtMC4wMjAzNzkwMyA1NC45MTg3ODUsOS4xOTI3NDIxZS00IFogbSAtMTQuNSw4LjIxODc1MDEyNTc5IGMgMi43Njk1NDcsMCA1LjAzMTI1LDIuMjk4NjQ1NiA1LjAzMTI1LDUuMTI0OTk5NiAtMmUtNiwyLjgxNjMzNiAtMi4yNjE3MDMsNS4wOTM3NSAtNS4wMzEyNSw1LjA5Mzc1IC0yLjc3OTQ3NiwtMWUtNiAtNS4wMzEyNSwtMi4yNzc0MTUgLTUuMDMxMjUsLTUuMDkzNzUgLTEwZS03LC0yLjgyNjM1MyAyLjI1MTc3NCwtNS4xMjQ5OTk2IDUuMDMxMjUsLTUuMTI0OTk5NiB6Ii8+CiAgPHBhdGggY2xhc3M9ImpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iI2ZmZDQzYiIgZD0ibSA4NS42Mzc1MzUsMjguNjU3MTY5IHYgMTEuOTA2MjUgYyAwLDkuMjMwNzU1IC03LjgyNTg5NSwxNi45OTk5OTkgLTE2Ljc1LDE3IGggLTI2Ljc4MTI1IGMgLTcuMzM1ODMzLDAgLTEzLjQwNjI0OSw2LjI3ODQ4MyAtMTMuNDA2MjUsMTMuNjI1IHYgMjUuNTMxMjQ3IGMgMCw3LjI2NjM0NCA2LjMxODU4OCwxMS41NDAzMjQgMTMuNDA2MjUsMTMuNjI1MDA0IDguNDg3MzMxLDIuNDk1NjEgMTYuNjI2MjM3LDIuOTQ2NjMgMjYuNzgxMjUsMCA2Ljc1MDE1NSwtMS45NTQzOSAxMy40MDYyNTMsLTUuODg3NjEgMTMuNDA2MjUsLTEzLjYyNTAwNCBWIDg2LjUwMDkxOSBoIC0yNi43ODEyNSB2IC0zLjQwNjI1IGggMjYuNzgxMjUgMTMuNDA2MjU0IGMgNy43OTI0NjEsMCAxMC42OTYyNTEsLTUuNDM1NDA4IDEzLjQwNjI0MSwtMTMuNTkzNzUgMi43OTkzMywtOC4zOTg4ODYgMi42ODAyMiwtMTYuNDc1Nzc2IDAsLTI3LjI1IC0xLjkyNTc4LC03Ljc1NzQ0MSAtNS42MDM4NywtMTMuNTkzNzUgLTEzLjQwNjI0MSwtMTMuNTkzNzUgeiBtIC0xNS4wNjI1LDY0LjY1NjI1IGMgMi43Nzk0NzgsM2UtNiA1LjAzMTI1LDIuMjc3NDE3IDUuMDMxMjUsNS4wOTM3NDcgLTJlLTYsMi44MjYzNTQgLTIuMjUxNzc1LDUuMTI1MDA0IC01LjAzMTI1LDUuMTI1MDA0IC0yLjc2OTU1LDAgLTUuMDMxMjUsLTIuMjk4NjUgLTUuMDMxMjUsLTUuMTI1MDA0IDJlLTYsLTIuODE2MzMgMi4yNjE2OTcsLTUuMDkzNzQ3IDUuMDMxMjUsLTUuMDkzNzQ3IHoiLz4KPC9zdmc+Cg==);
  --jp-icon-r-kernel: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8cGF0aCBjbGFzcz0ianAtaWNvbi1jb250cmFzdDMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjMjE5NkYzIiBkPSJNNC40IDIuNWMxLjItLjEgMi45LS4zIDQuOS0uMyAyLjUgMCA0LjEuNCA1LjIgMS4zIDEgLjcgMS41IDEuOSAxLjUgMy41IDAgMi0xLjQgMy41LTIuOSA0LjEgMS4yLjQgMS43IDEuNiAyLjIgMyAuNiAxLjkgMSAzLjkgMS4zIDQuNmgtMy44Yy0uMy0uNC0uOC0xLjctMS4yLTMuN3MtMS4yLTIuNi0yLjYtMi42aC0uOXY2LjRINC40VjIuNXptMy43IDYuOWgxLjRjMS45IDAgMi45LS45IDIuOS0yLjNzLTEtMi4zLTIuOC0yLjNjLS43IDAtMS4zIDAtMS42LjJ2NC41aC4xdi0uMXoiLz4KPC9zdmc+Cg==);
  --jp-icon-react: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMTUwIDE1MCA1NDEuOSAyOTUuMyI+CiAgPGcgY2xhc3M9ImpwLWljb24tYnJhbmQyIGpwLWljb24tc2VsZWN0YWJsZSIgZmlsbD0iIzYxREFGQiI+CiAgICA8cGF0aCBkPSJNNjY2LjMgMjk2LjVjMC0zMi41LTQwLjctNjMuMy0xMDMuMS04Mi40IDE0LjQtNjMuNiA4LTExNC4yLTIwLjItMTMwLjQtNi41LTMuOC0xNC4xLTUuNi0yMi40LTUuNnYyMi4zYzQuNiAwIDguMy45IDExLjQgMi42IDEzLjYgNy44IDE5LjUgMzcuNSAxNC45IDc1LjctMS4xIDkuNC0yLjkgMTkuMy01LjEgMjkuNC0xOS42LTQuOC00MS04LjUtNjMuNS0xMC45LTEzLjUtMTguNS0yNy41LTM1LjMtNDEuNi01MCAzMi42LTMwLjMgNjMuMi00Ni45IDg0LTQ2LjlWNzhjLTI3LjUgMC02My41IDE5LjYtOTkuOSA1My42LTM2LjQtMzMuOC03Mi40LTUzLjItOTkuOS01My4ydjIyLjNjMjAuNyAwIDUxLjQgMTYuNSA4NCA0Ni42LTE0IDE0LjctMjggMzEuNC00MS4zIDQ5LjktMjIuNiAyLjQtNDQgNi4xLTYzLjYgMTEtMi4zLTEwLTQtMTkuNy01LjItMjktNC43LTM4LjIgMS4xLTY3LjkgMTQuNi03NS44IDMtMS44IDYuOS0yLjYgMTEuNS0yLjZWNzguNWMtOC40IDAtMTYgMS44LTIyLjYgNS42LTI4LjEgMTYuMi0zNC40IDY2LjctMTkuOSAxMzAuMS02Mi4yIDE5LjItMTAyLjcgNDkuOS0xMDIuNyA4Mi4zIDAgMzIuNSA0MC43IDYzLjMgMTAzLjEgODIuNC0xNC40IDYzLjYtOCAxMTQuMiAyMC4yIDEzMC40IDYuNSAzLjggMTQuMSA1LjYgMjIuNSA1LjYgMjcuNSAwIDYzLjUtMTkuNiA5OS45LTUzLjYgMzYuNCAzMy44IDcyLjQgNTMuMiA5OS45IDUzLjIgOC40IDAgMTYtMS44IDIyLjYtNS42IDI4LjEtMTYuMiAzNC40LTY2LjcgMTkuOS0xMzAuMSA2Mi0xOS4xIDEwMi41LTQ5LjkgMTAyLjUtODIuM3ptLTEzMC4yLTY2LjdjLTMuNyAxMi45LTguMyAyNi4yLTEzLjUgMzkuNS00LjEtOC04LjQtMTYtMTMuMS0yNC00LjYtOC05LjUtMTUuOC0xNC40LTIzLjQgMTQuMiAyLjEgMjcuOSA0LjcgNDEgNy45em0tNDUuOCAxMDYuNWMtNy44IDEzLjUtMTUuOCAyNi4zLTI0LjEgMzguMi0xNC45IDEuMy0zMCAyLTQ1LjIgMi0xNS4xIDAtMzAuMi0uNy00NS0xLjktOC4zLTExLjktMTYuNC0yNC42LTI0LjItMzgtNy42LTEzLjEtMTQuNS0yNi40LTIwLjgtMzkuOCA2LjItMTMuNCAxMy4yLTI2LjggMjAuNy0zOS45IDcuOC0xMy41IDE1LjgtMjYuMyAyNC4xLTM4LjIgMTQuOS0xLjMgMzAtMiA0NS4yLTIgMTUuMSAwIDMwLjIuNyA0NSAxLjkgOC4zIDExLjkgMTYuNCAyNC42IDI0LjIgMzggNy42IDEzLjEgMTQuNSAyNi40IDIwLjggMzkuOC02LjMgMTMuNC0xMy4yIDI2LjgtMjAuNyAzOS45em0zMi4zLTEzYzUuNCAxMy40IDEwIDI2LjggMTMuOCAzOS44LTEzLjEgMy4yLTI2LjkgNS45LTQxLjIgOCA0LjktNy43IDkuOC0xNS42IDE0LjQtMjMuNyA0LjYtOCA4LjktMTYuMSAxMy0yNC4xek00MjEuMiA0MzBjLTkuMy05LjYtMTguNi0yMC4zLTI3LjgtMzIgOSAuNCAxOC4yLjcgMjcuNS43IDkuNCAwIDE4LjctLjIgMjcuOC0uNy05IDExLjctMTguMyAyMi40LTI3LjUgMzJ6bS03NC40LTU4LjljLTE0LjItMi4xLTI3LjktNC43LTQxLTcuOSAzLjctMTIuOSA4LjMtMjYuMiAxMy41LTM5LjUgNC4xIDggOC40IDE2IDEzLjEgMjQgNC43IDggOS41IDE1LjggMTQuNCAyMy40ek00MjAuNyAxNjNjOS4zIDkuNiAxOC42IDIwLjMgMjcuOCAzMi05LS40LTE4LjItLjctMjcuNS0uNy05LjQgMC0xOC43LjItMjcuOC43IDktMTEuNyAxOC4zLTIyLjQgMjcuNS0zMnptLTc0IDU4LjljLTQuOSA3LjctOS44IDE1LjYtMTQuNCAyMy43LTQuNiA4LTguOSAxNi0xMyAyNC01LjQtMTMuNC0xMC0yNi44LTEzLjgtMzkuOCAxMy4xLTMuMSAyNi45LTUuOCA0MS4yLTcuOXptLTkwLjUgMTI1LjJjLTM1LjQtMTUuMS01OC4zLTM0LjktNTguMy01MC42IDAtMTUuNyAyMi45LTM1LjYgNTguMy01MC42IDguNi0zLjcgMTgtNyAyNy43LTEwLjEgNS43IDE5LjYgMTMuMiA0MCAyMi41IDYwLjktOS4yIDIwLjgtMTYuNiA0MS4xLTIyLjIgNjAuNi05LjktMy4xLTE5LjMtNi41LTI4LTEwLjJ6TTMxMCA0OTBjLTEzLjYtNy44LTE5LjUtMzcuNS0xNC45LTc1LjcgMS4xLTkuNCAyLjktMTkuMyA1LjEtMjkuNCAxOS42IDQuOCA0MSA4LjUgNjMuNSAxMC45IDEzLjUgMTguNSAyNy41IDM1LjMgNDEuNiA1MC0zMi42IDMwLjMtNjMuMiA0Ni45LTg0IDQ2LjktNC41LS4xLTguMy0xLTExLjMtMi43em0yMzcuMi03Ni4yYzQuNyAzOC4yLTEuMSA2Ny45LTE0LjYgNzUuOC0zIDEuOC02LjkgMi42LTExLjUgMi42LTIwLjcgMC01MS40LTE2LjUtODQtNDYuNiAxNC0xNC43IDI4LTMxLjQgNDEuMy00OS45IDIyLjYtMi40IDQ0LTYuMSA2My42LTExIDIuMyAxMC4xIDQuMSAxOS44IDUuMiAyOS4xem0zOC41LTY2LjdjLTguNiAzLjctMTggNy0yNy43IDEwLjEtNS43LTE5LjYtMTMuMi00MC0yMi41LTYwLjkgOS4yLTIwLjggMTYuNi00MS4xIDIyLjItNjAuNiA5LjkgMy4xIDE5LjMgNi41IDI4LjEgMTAuMiAzNS40IDE1LjEgNTguMyAzNC45IDU4LjMgNTAuNi0uMSAxNS43LTIzIDM1LjYtNTguNCA1MC42ek0zMjAuOCA3OC40eiIvPgogICAgPGNpcmNsZSBjeD0iNDIwLjkiIGN5PSIyOTYuNSIgcj0iNDUuNyIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-redo: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgd2lkdGg9IjE2Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgICA8cGF0aCBkPSJNMCAwaDI0djI0SDB6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTE4LjQgMTAuNkMxNi41NSA4Ljk5IDE0LjE1IDggMTEuNSA4Yy00LjY1IDAtOC41OCAzLjAzLTkuOTYgNy4yMkwzLjkgMTZjMS4wNS0zLjE5IDQuMDUtNS41IDcuNi01LjUgMS45NSAwIDMuNzMuNzIgNS4xMiAxLjg4TDEzIDE2aDlWN2wtMy42IDMuNnoiLz4KICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-refresh: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDE4IDE4Ij4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTkgMTMuNWMtMi40OSAwLTQuNS0yLjAxLTQuNS00LjVTNi41MSA0LjUgOSA0LjVjMS4yNCAwIDIuMzYuNTIgMy4xNyAxLjMzTDEwIDhoNVYzbC0xLjc2IDEuNzZDMTIuMTUgMy42OCAxMC42NiAzIDkgMyA1LjY5IDMgMy4wMSA1LjY5IDMuMDEgOVM1LjY5IDE1IDkgMTVjMi45NyAwIDUuNDMtMi4xNiA1LjktNWgtMS41MmMtLjQ2IDItMi4yNCAzLjUtNC4zOCAzLjV6Ii8+CiAgICA8L2c+Cjwvc3ZnPgo=);
  --jp-icon-regex: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIwIDIwIj4KICA8ZyBjbGFzcz0ianAtaWNvbjIiIGZpbGw9IiM0MTQxNDEiPgogICAgPHJlY3QgeD0iMiIgeT0iMiIgd2lkdGg9IjE2IiBoZWlnaHQ9IjE2Ii8+CiAgPC9nPgoKICA8ZyBjbGFzcz0ianAtaWNvbi1hY2NlbnQyIiBmaWxsPSIjRkZGIj4KICAgIDxjaXJjbGUgY2xhc3M9InN0MiIgY3g9IjUuNSIgY3k9IjE0LjUiIHI9IjEuNSIvPgogICAgPHJlY3QgeD0iMTIiIHk9IjQiIGNsYXNzPSJzdDIiIHdpZHRoPSIxIiBoZWlnaHQ9IjgiLz4KICAgIDxyZWN0IHg9IjguNSIgeT0iNy41IiB0cmFuc2Zvcm09Im1hdHJpeCgwLjg2NiAtMC41IDAuNSAwLjg2NiAtMi4zMjU1IDcuMzIxOSkiIGNsYXNzPSJzdDIiIHdpZHRoPSI4IiBoZWlnaHQ9IjEiLz4KICAgIDxyZWN0IHg9IjEyIiB5PSI0IiB0cmFuc2Zvcm09Im1hdHJpeCgwLjUgLTAuODY2IDAuODY2IDAuNSAtMC42Nzc5IDE0LjgyNTIpIiBjbGFzcz0ic3QyIiB3aWR0aD0iMSIgaGVpZ2h0PSI4Ii8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-run: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTggNXYxNGwxMS03eiIvPgogICAgPC9nPgo8L3N2Zz4K);
  --jp-icon-running: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDUxMiA1MTIiPgogIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICA8cGF0aCBkPSJNMjU2IDhDMTE5IDggOCAxMTkgOCAyNTZzMTExIDI0OCAyNDggMjQ4IDI0OC0xMTEgMjQ4LTI0OFMzOTMgOCAyNTYgOHptOTYgMzI4YzAgOC44LTcuMiAxNi0xNiAxNkgxNzZjLTguOCAwLTE2LTcuMi0xNi0xNlYxNzZjMC04LjggNy4yLTE2IDE2LTE2aDE2MGM4LjggMCAxNiA3LjIgMTYgMTZ2MTYweiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-save: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTE3IDNINWMtMS4xMSAwLTIgLjktMiAydjE0YzAgMS4xLjg5IDIgMiAyaDE0YzEuMSAwIDItLjkgMi0yVjdsLTQtNHptLTUgMTZjLTEuNjYgMC0zLTEuMzQtMy0zczEuMzQtMyAzLTMgMyAxLjM0IDMgMy0xLjM0IDMtMyAzem0zLTEwSDVWNWgxMHY0eiIvPgogICAgPC9nPgo8L3N2Zz4K);
  --jp-icon-search: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMTggMTgiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTEyLjEsMTAuOWgtMC43bC0wLjItMC4yYzAuOC0wLjksMS4zLTIuMiwxLjMtMy41YzAtMy0yLjQtNS40LTUuNC01LjRTMS44LDQuMiwxLjgsNy4xczIuNCw1LjQsNS40LDUuNCBjMS4zLDAsMi41LTAuNSwzLjUtMS4zbDAuMiwwLjJ2MC43bDQuMSw0LjFsMS4yLTEuMkwxMi4xLDEwLjl6IE03LjEsMTAuOWMtMi4xLDAtMy43LTEuNy0zLjctMy43czEuNy0zLjcsMy43LTMuN3MzLjcsMS43LDMuNywzLjcgUzkuMiwxMC45LDcuMSwxMC45eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-settings: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8cGF0aCBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIiBkPSJNMTkuNDMgMTIuOThjLjA0LS4zMi4wNy0uNjQuMDctLjk4cy0uMDMtLjY2LS4wNy0uOThsMi4xMS0xLjY1Yy4xOS0uMTUuMjQtLjQyLjEyLS42NGwtMi0zLjQ2Yy0uMTItLjIyLS4zOS0uMy0uNjEtLjIybC0yLjQ5IDFjLS41Mi0uNC0xLjA4LS43My0xLjY5LS45OGwtLjM4LTIuNjVBLjQ4OC40ODggMCAwMDE0IDJoLTRjLS4yNSAwLS40Ni4xOC0uNDkuNDJsLS4zOCAyLjY1Yy0uNjEuMjUtMS4xNy41OS0xLjY5Ljk4bC0yLjQ5LTFjLS4yMy0uMDktLjQ5IDAtLjYxLjIybC0yIDMuNDZjLS4xMy4yMi0uMDcuNDkuMTIuNjRsMi4xMSAxLjY1Yy0uMDQuMzItLjA3LjY1LS4wNy45OHMuMDMuNjYuMDcuOThsLTIuMTEgMS42NWMtLjE5LjE1LS4yNC40Mi0uMTIuNjRsMiAzLjQ2Yy4xMi4yMi4zOS4zLjYxLjIybDIuNDktMWMuNTIuNCAxLjA4LjczIDEuNjkuOThsLjM4IDIuNjVjLjAzLjI0LjI0LjQyLjQ5LjQyaDRjLjI1IDAgLjQ2LS4xOC40OS0uNDJsLjM4LTIuNjVjLjYxLS4yNSAxLjE3LS41OSAxLjY5LS45OGwyLjQ5IDFjLjIzLjA5LjQ5IDAgLjYxLS4yMmwyLTMuNDZjLjEyLS4yMi4wNy0uNDktLjEyLS42NGwtMi4xMS0xLjY1ek0xMiAxNS41Yy0xLjkzIDAtMy41LTEuNTctMy41LTMuNXMxLjU3LTMuNSAzLjUtMy41IDMuNSAxLjU3IDMuNSAzLjUtMS41NyAzLjUtMy41IDMuNXoiLz4KPC9zdmc+Cg==);
  --jp-icon-share: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTSAxOCAyIEMgMTYuMzU0OTkgMiAxNSAzLjM1NDk5MDQgMTUgNSBDIDE1IDUuMTkwOTUyOSAxNS4wMjE3OTEgNS4zNzcxMjI0IDE1LjA1NjY0MSA1LjU1ODU5MzggTCA3LjkyMTg3NSA5LjcyMDcwMzEgQyA3LjM5ODUzOTkgOS4yNzc4NTM5IDYuNzMyMDc3MSA5IDYgOSBDIDQuMzU0OTkwNCA5IDMgMTAuMzU0OTkgMyAxMiBDIDMgMTMuNjQ1MDEgNC4zNTQ5OTA0IDE1IDYgMTUgQyA2LjczMjA3NzEgMTUgNy4zOTg1Mzk5IDE0LjcyMjE0NiA3LjkyMTg3NSAxNC4yNzkyOTcgTCAxNS4wNTY2NDEgMTguNDM5NDUzIEMgMTUuMDIxNTU1IDE4LjYyMTUxNCAxNSAxOC44MDgzODYgMTUgMTkgQyAxNSAyMC42NDUwMSAxNi4zNTQ5OSAyMiAxOCAyMiBDIDE5LjY0NTAxIDIyIDIxIDIwLjY0NTAxIDIxIDE5IEMgMjEgMTcuMzU0OTkgMTkuNjQ1MDEgMTYgMTggMTYgQyAxNy4yNjc0OCAxNiAxNi42MDE1OTMgMTYuMjc5MzI4IDE2LjA3ODEyNSAxNi43MjI2NTYgTCA4Ljk0MzM1OTQgMTIuNTU4NTk0IEMgOC45NzgyMDk1IDEyLjM3NzEyMiA5IDEyLjE5MDk1MyA5IDEyIEMgOSAxMS44MDkwNDcgOC45NzgyMDk1IDExLjYyMjg3OCA4Ljk0MzM1OTQgMTEuNDQxNDA2IEwgMTYuMDc4MTI1IDcuMjc5Mjk2OSBDIDE2LjYwMTQ2IDcuNzIyMTQ2MSAxNy4yNjc5MjMgOCAxOCA4IEMgMTkuNjQ1MDEgOCAyMSA2LjY0NTAwOTYgMjEgNSBDIDIxIDMuMzU0OTkwNCAxOS42NDUwMSAyIDE4IDIgeiBNIDE4IDQgQyAxOC41NjQxMjkgNCAxOSA0LjQzNTg3MDYgMTkgNSBDIDE5IDUuNTY0MTI5NCAxOC41NjQxMjkgNiAxOCA2IEMgMTcuNDM1ODcxIDYgMTcgNS41NjQxMjk0IDE3IDUgQyAxNyA0LjQzNTg3MDYgMTcuNDM1ODcxIDQgMTggNCB6IE0gNiAxMSBDIDYuNTY0MTI5NCAxMSA3IDExLjQzNTg3MSA3IDEyIEMgNyAxMi41NjQxMjkgNi41NjQxMjk0IDEzIDYgMTMgQyA1LjQzNTg3MDYgMTMgNSAxMi41NjQxMjkgNSAxMiBDIDUgMTEuNDM1ODcxIDUuNDM1ODcwNiAxMSA2IDExIHogTSAxOCAxOCBDIDE4LjU2NDEyOSAxOCAxOSAxOC40MzU4NzEgMTkgMTkgQyAxOSAxOS41NjQxMjkgMTguNTY0MTI5IDIwIDE4IDIwIEMgMTcuNDM1ODcxIDIwIDE3IDE5LjU2NDEyOSAxNyAxOSBDIDE3IDE4LjQzNTg3MSAxNy40MzU4NzEgMTggMTggMTggeiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-spreadsheet: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8cGF0aCBjbGFzcz0ianAtaWNvbi1jb250cmFzdDEganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNENBRjUwIiBkPSJNMi4yIDIuMnYxNy42aDE3LjZWMi4ySDIuMnptMTUuNCA3LjdoLTUuNVY0LjRoNS41djUuNXpNOS45IDQuNHY1LjVINC40VjQuNGg1LjV6bS01LjUgNy43aDUuNXY1LjVINC40di01LjV6bTcuNyA1LjV2LTUuNWg1LjV2NS41aC01LjV6Ii8+Cjwvc3ZnPgo=);
  --jp-icon-stop: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTAgMGgyNHYyNEgweiIgZmlsbD0ibm9uZSIvPgogICAgICAgIDxwYXRoIGQ9Ik02IDZoMTJ2MTJINnoiLz4KICAgIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-tab: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTIxIDNIM2MtMS4xIDAtMiAuOS0yIDJ2MTRjMCAxLjEuOSAyIDIgMmgxOGMxLjEgMCAyLS45IDItMlY1YzAtMS4xLS45LTItMi0yem0wIDE2SDNWNWgxMHY0aDh2MTB6Ii8+CiAgPC9nPgo8L3N2Zz4K);
  --jp-icon-table-rows: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTAgMGgyNHYyNEgweiIgZmlsbD0ibm9uZSIvPgogICAgICAgIDxwYXRoIGQ9Ik0yMSw4SDNWNGgxOFY4eiBNMjEsMTBIM3Y0aDE4VjEweiBNMjEsMTZIM3Y0aDE4VjE2eiIvPgogICAgPC9nPgo8L3N2Zz4K);
  --jp-icon-tag: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgiIGhlaWdodD0iMjgiIHZpZXdCb3g9IjAgMCA0MyAyOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KCTxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CgkJPHBhdGggZD0iTTI4LjgzMzIgMTIuMzM0TDMyLjk5OTggMTYuNTAwN0wzNy4xNjY1IDEyLjMzNEgyOC44MzMyWiIvPgoJCTxwYXRoIGQ9Ik0xNi4yMDk1IDIxLjYxMDRDMTUuNjg3MyAyMi4xMjk5IDE0Ljg0NDMgMjIuMTI5OSAxNC4zMjQ4IDIxLjYxMDRMNi45ODI5IDE0LjcyNDVDNi41NzI0IDE0LjMzOTQgNi4wODMxMyAxMy42MDk4IDYuMDQ3ODYgMTMuMDQ4MkM1Ljk1MzQ3IDExLjUyODggNi4wMjAwMiA4LjYxOTQ0IDYuMDY2MjEgNy4wNzY5NUM2LjA4MjgxIDYuNTE0NzcgNi41NTU0OCA2LjA0MzQ3IDcuMTE4MDQgNi4wMzA1NUM5LjA4ODYzIDUuOTg0NzMgMTMuMjYzOCA1LjkzNTc5IDEzLjY1MTggNi4zMjQyNUwyMS43MzY5IDEzLjYzOUMyMi4yNTYgMTQuMTU4NSAyMS43ODUxIDE1LjQ3MjQgMjEuMjYyIDE1Ljk5NDZMMTYuMjA5NSAyMS42MTA0Wk05Ljc3NTg1IDguMjY1QzkuMzM1NTEgNy44MjU2NiA4LjYyMzUxIDcuODI1NjYgOC4xODI4IDguMjY1QzcuNzQzNDYgOC43MDU3MSA3Ljc0MzQ2IDkuNDE3MzMgOC4xODI4IDkuODU2NjdDOC42MjM4MiAxMC4yOTY0IDkuMzM1ODIgMTAuMjk2NCA5Ljc3NTg1IDkuODU2NjdDMTAuMjE1NiA5LjQxNzMzIDEwLjIxNTYgOC43MDUzMyA5Ljc3NTg1IDguMjY1WiIvPgoJPC9nPgo8L3N2Zz4K);
  --jp-icon-terminal: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0IiA+CiAgICA8cmVjdCBjbGFzcz0ianAtdGVybWluYWwtaWNvbi1iYWNrZ3JvdW5kLWNvbG9yIGpwLWljb24tc2VsZWN0YWJsZSIgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyIDIpIiBmaWxsPSIjMzMzMzMzIi8+CiAgICA8cGF0aCBjbGFzcz0ianAtdGVybWluYWwtaWNvbi1jb2xvciBqcC1pY29uLXNlbGVjdGFibGUtaW52ZXJzZSIgZD0iTTUuMDU2NjQgOC43NjE3MkM1LjA1NjY0IDguNTk3NjYgNS4wMzEyNSA4LjQ1MzEyIDQuOTgwNDcgOC4zMjgxMkM0LjkzMzU5IDguMTk5MjIgNC44NTU0NyA4LjA4MjAzIDQuNzQ2MDkgNy45NzY1NkM0LjY0MDYyIDcuODcxMDkgNC41IDcuNzc1MzkgNC4zMjQyMiA3LjY4OTQ1QzQuMTUyMzQgNy41OTk2MSAzLjk0MzM2IDcuNTExNzIgMy42OTcyNyA3LjQyNTc4QzMuMzAyNzMgNy4yODUxNiAyLjk0MzM2IDcuMTM2NzIgMi42MTkxNCA2Ljk4MDQ3QzIuMjk0OTIgNi44MjQyMiAyLjAxNzU4IDYuNjQyNTggMS43ODcxMSA2LjQzNTU1QzEuNTYwNTUgNi4yMjg1MiAxLjM4NDc3IDUuOTg4MjggMS4yNTk3NyA1LjcxNDg0QzEuMTM0NzcgNS40Mzc1IDEuMDcyMjcgNS4xMDkzOCAxLjA3MjI3IDQuNzMwNDdDMS4wNzIyNyA0LjM5ODQ0IDEuMTI4OTEgNC4wOTU3IDEuMjQyMTkgMy44MjIyN0MxLjM1NTQ3IDMuNTQ0OTIgMS41MTU2MiAzLjMwNDY5IDEuNzIyNjYgMy4xMDE1NkMxLjkyOTY5IDIuODk4NDQgMi4xNzk2OSAyLjczNDM3IDIuNDcyNjYgMi42MDkzOEMyLjc2NTYyIDIuNDg0MzggMy4wOTE4IDIuNDA0MyAzLjQ1MTE3IDIuMzY5MTRWMS4xMDkzOEg0LjM4ODY3VjIuMzgwODZDNC43NDAyMyAyLjQyNzczIDUuMDU2NjQgMi41MjM0NCA1LjMzNzg5IDIuNjY3OTdDNS42MTkxNCAyLjgxMjUgNS44NTc0MiAzLjAwMTk1IDYuMDUyNzMgMy4yMzYzM0M2LjI1MTk1IDMuNDY2OCA2LjQwNDMgMy43NDAyMyA2LjUwOTc3IDQuMDU2NjRDNi42MTkxNCA0LjM2OTE0IDYuNjczODMgNC43MjA3IDYuNjczODMgNS4xMTEzM0g1LjA0NDkyQzUuMDQ0OTIgNC42Mzg2NyA0LjkzNzUgNC4yODEyNSA0LjcyMjY2IDQuMDM5MDZDNC41MDc4MSAzLjc5Mjk3IDQuMjE2OCAzLjY2OTkyIDMuODQ5NjEgMy42Njk5MkMzLjY1MDM5IDMuNjY5OTIgMy40NzY1NiAzLjY5NzI3IDMuMzI4MTIgMy43NTE5NUMzLjE4MzU5IDMuODAyNzMgMy4wNjQ0NSAzLjg3Njk1IDIuOTcwNyAzLjk3NDYxQzIuODc2OTUgNC4wNjgzNiAyLjgwNjY0IDQuMTc5NjkgMi43NTk3NyA0LjMwODU5QzIuNzE2OCA0LjQzNzUgMi42OTUzMSA0LjU3ODEyIDIuNjk1MzEgNC43MzA0N0MyLjY5NTMxIDQuODgyODEgMi43MTY4IDUuMDE5NTMgMi43NTk3NyA1LjE0MDYyQzIuODA2NjQgNS4yNTc4MSAyLjg4MjgxIDUuMzY3MTkgMi45ODgyOCA1LjQ2ODc1QzMuMDk3NjYgNS41NzAzMSAzLjI0MDIzIDUuNjY3OTcgMy40MTYwMiA1Ljc2MTcyQzMuNTkxOCA1Ljg1MTU2IDMuODEwNTUgNS45NDMzNiA0LjA3MjI3IDYuMDM3MTFDNC40NjY4IDYuMTg1NTUgNC44MjQyMiA2LjMzOTg0IDUuMTQ0NTMgNi41QzUuNDY0ODQgNi42NTYyNSA1LjczODI4IDYuODM5ODQgNS45NjQ4NCA3LjA1MDc4QzYuMTk1MzEgNy4yNTc4MSA2LjM3MTA5IDcuNSA2LjQ5MjE5IDcuNzc3MzRDNi42MTcxOSA4LjA1MDc4IDYuNjc5NjkgOC4zNzUgNi42Nzk2OSA4Ljc1QzYuNjc5NjkgOS4wOTM3NSA2LjYyMzA1IDkuNDA0MyA2LjUwOTc3IDkuNjgxNjRDNi4zOTY0OCA5Ljk1NTA4IDYuMjM0MzggMTAuMTkxNCA2LjAyMzQ0IDEwLjM5MDZDNS44MTI1IDEwLjU4OTggNS41NTg1OSAxMC43NSA1LjI2MTcyIDEwLjg3MTFDNC45NjQ4NCAxMC45ODgzIDQuNjMyODEgMTEuMDY0NSA0LjI2NTYyIDExLjA5OTZWMTIuMjQ4SDMuMzMzOThWMTEuMDk5NkMzLjAwMTk1IDExLjA2ODQgMi42Nzk2OSAxMC45OTYxIDIuMzY3MTkgMTAuODgyOEMyLjA1NDY5IDEwLjc2NTYgMS43NzczNCAxMC41OTc3IDEuNTM1MTYgMTAuMzc4OUMxLjI5Njg4IDEwLjE2MDIgMS4xMDU0NyA5Ljg4NDc3IDAuOTYwOTM4IDkuNTUyNzNDMC44MTY0MDYgOS4yMTY4IDAuNzQ0MTQxIDguODE0NDUgMC43NDQxNDEgOC4zNDU3SDIuMzc4OTFDMi4zNzg5MSA4LjYyNjk1IDIuNDE5OTIgOC44NjMyOCAyLjUwMTk1IDkuMDU0NjlDMi41ODM5OCA5LjI0MjE5IDIuNjg5NDUgOS4zOTI1OCAyLjgxODM2IDkuNTA1ODZDMi45NTExNyA5LjYxNTIzIDMuMTAxNTYgOS42OTMzNiAzLjI2OTUzIDkuNzQwMjNDMy40Mzc1IDkuNzg3MTEgMy42MDkzOCA5LjgxMDU1IDMuNzg1MTYgOS44MTA1NUM0LjIwMzEyIDkuODEwNTUgNC41MTk1MyA5LjcxMjg5IDQuNzM0MzggOS41MTc1OEM0Ljk0OTIyIDkuMzIyMjcgNS4wNTY2NCA5LjA3MDMxIDUuMDU2NjQgOC43NjE3MlpNMTMuNDE4IDEyLjI3MTVIOC4wNzQyMlYxMUgxMy40MThWMTIuMjcxNVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMuOTUyNjQgNikiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo=);
  --jp-icon-text-editor: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8cGF0aCBjbGFzcz0ianAtdGV4dC1lZGl0b3ItaWNvbi1jb2xvciBqcC1pY29uLXNlbGVjdGFibGUiIGZpbGw9IiM2MTYxNjEiIGQ9Ik0xNSAxNUgzdjJoMTJ2LTJ6bTAtOEgzdjJoMTJWN3pNMyAxM2gxOHYtMkgzdjJ6bTAgOGgxOHYtMkgzdjJ6TTMgM3YyaDE4VjNIM3oiLz4KPC9zdmc+Cg==);
  --jp-icon-toc: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij4KICA8ZyBjbGFzcz0ianAtaWNvbjMganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjNjE2MTYxIj4KICAgIDxwYXRoIGQ9Ik03LDVIMjFWN0g3VjVNNywxM1YxMUgyMVYxM0g3TTQsNC41QTEuNSwxLjUgMCAwLDEgNS41LDZBMS41LDEuNSAwIDAsMSA0LDcuNUExLjUsMS41IDAgMCwxIDIuNSw2QTEuNSwxLjUgMCAwLDEgNCw0LjVNNCwxMC41QTEuNSwxLjUgMCAwLDEgNS41LDEyQTEuNSwxLjUgMCAwLDEgNCwxMy41QTEuNSwxLjUgMCAwLDEgMi41LDEyQTEuNSwxLjUgMCAwLDEgNCwxMC41TTcsMTlWMTdIMjFWMTlIN000LDE2LjVBMS41LDEuNSAwIDAsMSA1LjUsMThBMS41LDEuNSAwIDAsMSA0LDE5LjVBMS41LDEuNSAwIDAsMSAyLjUsMThBMS41LDEuNSAwIDAsMSA0LDE2LjVaIiAvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-tree-view: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGNsYXNzPSJqcC1pY29uMyIgZmlsbD0iIzYxNjE2MSI+CiAgICAgICAgPHBhdGggZD0iTTAgMGgyNHYyNEgweiIgZmlsbD0ibm9uZSIvPgogICAgICAgIDxwYXRoIGQ9Ik0yMiAxMVYzaC03djNIOVYzSDJ2OGg3VjhoMnYxMGg0djNoN3YtOGgtN3YzaC0yVjhoMnYzeiIvPgogICAgPC9nPgo8L3N2Zz4K);
  --jp-icon-trusted: url(data:image/svg+xml;base64,PHN2ZyBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDI0IDI1Ij4KICAgIDxwYXRoIGNsYXNzPSJqcC1pY29uMiIgc3Ryb2tlPSIjMzMzMzMzIiBzdHJva2Utd2lkdGg9IjIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDIgMykiIGQ9Ik0xLjg2MDk0IDExLjQ0MDlDMC44MjY0NDggOC43NzAyNyAwLjg2Mzc3OSA2LjA1NzY0IDEuMjQ5MDcgNC4xOTkzMkMyLjQ4MjA2IDMuOTMzNDcgNC4wODA2OCAzLjQwMzQ3IDUuNjAxMDIgMi44NDQ5QzcuMjM1NDkgMi4yNDQ0IDguODU2NjYgMS41ODE1IDkuOTg3NiAxLjA5NTM5QzExLjA1OTcgMS41ODM0MSAxMi42MDk0IDIuMjQ0NCAxNC4yMTggMi44NDMzOUMxNS43NTAzIDMuNDEzOTQgMTcuMzk5NSAzLjk1MjU4IDE4Ljc1MzkgNC4yMTM4NUMxOS4xMzY0IDYuMDcxNzcgMTkuMTcwOSA4Ljc3NzIyIDE4LjEzOSAxMS40NDA5QzE3LjAzMDMgMTQuMzAzMiAxNC42NjY4IDE3LjE4NDQgOS45OTk5OSAxOC45MzU0QzUuMzMzMiAxNy4xODQ0IDIuOTY5NjggMTQuMzAzMiAxLjg2MDk0IDExLjQ0MDlaIi8+CiAgICA8cGF0aCBjbGFzcz0ianAtaWNvbjIiIGZpbGw9IiMzMzMzMzMiIHN0cm9rZT0iIzMzMzMzMyIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoOCA5Ljg2NzE5KSIgZD0iTTIuODYwMTUgNC44NjUzNUwwLjcyNjU0OSAyLjk5OTU5TDAgMy42MzA0NUwyLjg2MDE1IDYuMTMxNTdMOCAwLjYzMDg3Mkw3LjI3ODU3IDBMMi44NjAxNSA0Ljg2NTM1WiIvPgo8L3N2Zz4K);
  --jp-icon-undo: url(data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTEyLjUgOGMtMi42NSAwLTUuMDUuOTktNi45IDIuNkwyIDd2OWg5bC0zLjYyLTMuNjJjMS4zOS0xLjE2IDMuMTYtMS44OCA1LjEyLTEuODggMy41NCAwIDYuNTUgMi4zMSA3LjYgNS41bDIuMzctLjc4QzIxLjA4IDExLjAzIDE3LjE1IDggMTIuNSA4eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-user: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZyBjbGFzcz0ianAtaWNvbjMiIGZpbGw9IiM2MTYxNjEiPgogICAgPHBhdGggZD0iTTE2IDdhNCA0IDAgMTEtOCAwIDQgNCAwIDAxOCAwek0xMiAxNGE3IDcgMCAwMC03IDdoMTRhNyA3IDAgMDAtNy03eiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-users: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDM2IDI0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogPGcgY2xhc3M9ImpwLWljb24zIiB0cmFuc2Zvcm09Im1hdHJpeCgxLjczMjcgMCAwIDEuNzMyNyAtMy42MjgyIC4wOTk1NzcpIiBmaWxsPSIjNjE2MTYxIj4KICA8cGF0aCB0cmFuc2Zvcm09Im1hdHJpeCgxLjUsMCwwLDEuNSwwLC02KSIgZD0ibTEyLjE4NiA3LjUwOThjLTEuMDUzNSAwLTEuOTc1NyAwLjU2NjUtMi40Nzg1IDEuNDEwMiAwLjc1MDYxIDAuMzEyNzcgMS4zOTc0IDAuODI2NDggMS44NzMgMS40NzI3aDMuNDg2M2MwLTEuNTkyLTEuMjg4OS0yLjg4MjgtMi44ODA5LTIuODgyOHoiLz4KICA8cGF0aCBkPSJtMjAuNDY1IDIuMzg5NWEyLjE4ODUgMi4xODg1IDAgMCAxLTIuMTg4NCAyLjE4ODUgMi4xODg1IDIuMTg4NSAwIDAgMS0yLjE4ODUtMi4xODg1IDIuMTg4NSAyLjE4ODUgMCAwIDEgMi4xODg1LTIuMTg4NSAyLjE4ODUgMi4xODg1IDAgMCAxIDIuMTg4NCAyLjE4ODV6Ii8+CiAgPHBhdGggdHJhbnNmb3JtPSJtYXRyaXgoMS41LDAsMCwxLjUsMCwtNikiIGQ9Im0zLjU4OTggOC40MjE5Yy0xLjExMjYgMC0yLjAxMzcgMC45MDExMS0yLjAxMzcgMi4wMTM3aDIuODE0NWMwLjI2Nzk3LTAuMzczMDkgMC41OTA3LTAuNzA0MzUgMC45NTg5OC0wLjk3ODUyLTAuMzQ0MzMtMC42MTY4OC0xLjAwMzEtMS4wMzUyLTEuNzU5OC0xLjAzNTJ6Ii8+CiAgPHBhdGggZD0ibTYuOTE1NCA0LjYyM2ExLjUyOTQgMS41Mjk0IDAgMCAxLTEuNTI5NCAxLjUyOTQgMS41Mjk0IDEuNTI5NCAwIDAgMS0xLjUyOTQtMS41Mjk0IDEuNTI5NCAxLjUyOTQgMCAwIDEgMS41Mjk0LTEuNTI5NCAxLjUyOTQgMS41Mjk0IDAgMCAxIDEuNTI5NCAxLjUyOTR6Ii8+CiAgPHBhdGggZD0ibTYuMTM1IDEzLjUzNWMwLTMuMjM5MiAyLjYyNTktNS44NjUgNS44NjUtNS44NjUgMy4yMzkyIDAgNS44NjUgMi42MjU5IDUuODY1IDUuODY1eiIvPgogIDxjaXJjbGUgY3g9IjEyIiBjeT0iMy43Njg1IiByPSIyLjk2ODUiLz4KIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-vega: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8ZyBjbGFzcz0ianAtaWNvbjEganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjMjEyMTIxIj4KICAgIDxwYXRoIGQ9Ik0xMC42IDUuNGwyLjItMy4ySDIuMnY3LjNsNC02LjZ6Ii8+CiAgICA8cGF0aCBkPSJNMTUuOCAyLjJsLTQuNCA2LjZMNyA2LjNsLTQuOCA4djUuNWgxNy42VjIuMmgtNHptLTcgMTUuNEg1LjV2LTQuNGgzLjN2NC40em00LjQgMEg5LjhWOS44aDMuNHY3Ljh6bTQuNCAwaC0zLjRWNi41aDMuNHYxMS4xeiIvPgogIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-word: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIwIDIwIj4KIDxnIGNsYXNzPSJqcC1pY29uMiIgZmlsbD0iIzQxNDE0MSI+CiAgPHJlY3QgeD0iMiIgeT0iMiIgd2lkdGg9IjE2IiBoZWlnaHQ9IjE2Ii8+CiA8L2c+CiA8ZyBjbGFzcz0ianAtaWNvbi1hY2NlbnQyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSguNDMgLjA0MDEpIiBmaWxsPSIjZmZmIj4KICA8cGF0aCBkPSJtNC4xNCA4Ljc2cTAuMDY4Mi0xLjg5IDIuNDItMS44OSAxLjE2IDAgMS42OCAwLjQyIDAuNTY3IDAuNDEgMC41NjcgMS4xNnYzLjQ3cTAgMC40NjIgMC41MTQgMC40NjIgMC4xMDMgMCAwLjItMC4wMjMxdjAuNzE0cS0wLjM5OSAwLjEwMy0wLjY1MSAwLjEwMy0wLjQ1MiAwLTAuNjkzLTAuMjItMC4yMzEtMC4yLTAuMjg0LTAuNjYyLTAuOTU2IDAuODcyLTIgMC44NzItMC45MDMgMC0xLjQ3LTAuNDcyLTAuNTI1LTAuNDcyLTAuNTI1LTEuMjYgMC0wLjI2MiAwLjA0NTItMC40NzIgMC4wNTY3LTAuMjIgMC4xMTYtMC4zNzggMC4wNjgyLTAuMTY4IDAuMjMxLTAuMzA0IDAuMTU4LTAuMTQ3IDAuMjYyLTAuMjQyIDAuMTE2LTAuMDkxNCAwLjM2OC0wLjE2OCAwLjI2Mi0wLjA5MTQgMC4zOTktMC4xMjYgMC4xMzYtMC4wNDUyIDAuNDcyLTAuMTAzIDAuMzM2LTAuMDU3OCAwLjUwNC0wLjA3OTggMC4xNTgtMC4wMjMxIDAuNTY3LTAuMDc5OCAwLjU1Ni0wLjA2ODIgMC43NzctMC4yMjEgMC4yMi0wLjE1MiAwLjIyLTAuNDQxdi0wLjI1MnEwLTAuNDMtMC4zNTctMC42NjItMC4zMzYtMC4yMzEtMC45NzYtMC4yMzEtMC42NjIgMC0wLjk5OCAwLjI2Mi0wLjMzNiAwLjI1Mi0wLjM5OSAwLjc5OHptMS44OSAzLjY4cTAuNzg4IDAgMS4yNi0wLjQxIDAuNTA0LTAuNDIgMC41MDQtMC45MDN2LTEuMDVxLTAuMjg0IDAuMTM2LTAuODYxIDAuMjMxLTAuNTY3IDAuMDkxNC0wLjk4NyAwLjE1OC0wLjQyIDAuMDY4Mi0wLjc2NiAwLjMyNi0wLjMzNiAwLjI1Mi0wLjMzNiAwLjcwNHQwLjMwNCAwLjcwNCAwLjg2MSAwLjI1MnoiIHN0cm9rZS13aWR0aD0iMS4wNSIvPgogIDxwYXRoIGQ9Im0xMCA0LjU2aDAuOTQ1djMuMTVxMC42NTEtMC45NzYgMS44OS0wLjk3NiAxLjE2IDAgMS44OSAwLjg0IDAuNjgyIDAuODQgMC42ODIgMi4zMSAwIDEuNDctMC43MDQgMi40Mi0wLjcwNCAwLjg4Mi0xLjg5IDAuODgyLTEuMjYgMC0xLjg5LTEuMDJ2MC43NjZoLTAuODV6bTIuNjIgMy4wNHEtMC43NDYgMC0xLjE2IDAuNjQtMC40NTIgMC42My0wLjQ1MiAxLjY4IDAgMS4wNSAwLjQ1MiAxLjY4dDEuMTYgMC42M3EwLjc3NyAwIDEuMjYtMC42MyAwLjQ5NC0wLjY0IDAuNDk0LTEuNjggMC0xLjA1LTAuNDcyLTEuNjgtMC40NjItMC42NC0xLjI2LTAuNjR6IiBzdHJva2Utd2lkdGg9IjEuMDUiLz4KICA8cGF0aCBkPSJtMi43MyAxNS44IDEzLjYgMC4wMDgxYzAuMDA2OSAwIDAtMi42IDAtMi42IDAtMC4wMDc4LTEuMTUgMC0xLjE1IDAtMC4wMDY5IDAtMC4wMDgzIDEuNS0wLjAwODMgMS41LTJlLTMgLTAuMDAxNC0xMS4zLTAuMDAxNC0xMS4zLTAuMDAxNGwtMC4wMDU5Mi0xLjVjMC0wLjAwNzgtMS4xNyAwLjAwMTMtMS4xNyAwLjAwMTN6IiBzdHJva2Utd2lkdGg9Ii45NzUiLz4KIDwvZz4KPC9zdmc+Cg==);
  --jp-icon-yaml: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgdmlld0JveD0iMCAwIDIyIDIyIj4KICA8ZyBjbGFzcz0ianAtaWNvbi1jb250cmFzdDIganAtaWNvbi1zZWxlY3RhYmxlIiBmaWxsPSIjRDgxQjYwIj4KICAgIDxwYXRoIGQ9Ik03LjIgMTguNnYtNS40TDMgNS42aDMuM2wxLjQgMy4xYy4zLjkuNiAxLjYgMSAyLjUuMy0uOC42LTEuNiAxLTIuNWwxLjQtMy4xaDMuNGwtNC40IDcuNnY1LjVsLTIuOS0uMXoiLz4KICAgIDxjaXJjbGUgY2xhc3M9InN0MCIgY3g9IjE3LjYiIGN5PSIxNi41IiByPSIyLjEiLz4KICAgIDxjaXJjbGUgY2xhc3M9InN0MCIgY3g9IjE3LjYiIGN5PSIxMSIgcj0iMi4xIi8+CiAgPC9nPgo8L3N2Zz4K);
}

/* Icon CSS class declarations */

.jp-AddAboveIcon {
  background-image: var(--jp-icon-add-above);
}

.jp-AddBelowIcon {
  background-image: var(--jp-icon-add-below);
}

.jp-AddIcon {
  background-image: var(--jp-icon-add);
}

.jp-BellIcon {
  background-image: var(--jp-icon-bell);
}

.jp-BugDotIcon {
  background-image: var(--jp-icon-bug-dot);
}

.jp-BugIcon {
  background-image: var(--jp-icon-bug);
}

.jp-BuildIcon {
  background-image: var(--jp-icon-build);
}

.jp-CaretDownEmptyIcon {
  background-image: var(--jp-icon-caret-down-empty);
}

.jp-CaretDownEmptyThinIcon {
  background-image: var(--jp-icon-caret-down-empty-thin);
}

.jp-CaretDownIcon {
  background-image: var(--jp-icon-caret-down);
}

.jp-CaretLeftIcon {
  background-image: var(--jp-icon-caret-left);
}

.jp-CaretRightIcon {
  background-image: var(--jp-icon-caret-right);
}

.jp-CaretUpEmptyThinIcon {
  background-image: var(--jp-icon-caret-up-empty-thin);
}

.jp-CaretUpIcon {
  background-image: var(--jp-icon-caret-up);
}

.jp-CaseSensitiveIcon {
  background-image: var(--jp-icon-case-sensitive);
}

.jp-CheckIcon {
  background-image: var(--jp-icon-check);
}

.jp-CircleEmptyIcon {
  background-image: var(--jp-icon-circle-empty);
}

.jp-CircleIcon {
  background-image: var(--jp-icon-circle);
}

.jp-ClearIcon {
  background-image: var(--jp-icon-clear);
}

.jp-CloseIcon {
  background-image: var(--jp-icon-close);
}

.jp-CodeCheckIcon {
  background-image: var(--jp-icon-code-check);
}

.jp-CodeIcon {
  background-image: var(--jp-icon-code);
}

.jp-CollapseAllIcon {
  background-image: var(--jp-icon-collapse-all);
}

.jp-ConsoleIcon {
  background-image: var(--jp-icon-console);
}

.jp-CopyIcon {
  background-image: var(--jp-icon-copy);
}

.jp-CopyrightIcon {
  background-image: var(--jp-icon-copyright);
}

.jp-CutIcon {
  background-image: var(--jp-icon-cut);
}

.jp-DeleteIcon {
  background-image: var(--jp-icon-delete);
}

.jp-DownloadIcon {
  background-image: var(--jp-icon-download);
}

.jp-DuplicateIcon {
  background-image: var(--jp-icon-duplicate);
}

.jp-EditIcon {
  background-image: var(--jp-icon-edit);
}

.jp-EllipsesIcon {
  background-image: var(--jp-icon-ellipses);
}

.jp-ErrorIcon {
  background-image: var(--jp-icon-error);
}

.jp-ExpandAllIcon {
  background-image: var(--jp-icon-expand-all);
}

.jp-ExtensionIcon {
  background-image: var(--jp-icon-extension);
}

.jp-FastForwardIcon {
  background-image: var(--jp-icon-fast-forward);
}

.jp-FileIcon {
  background-image: var(--jp-icon-file);
}

.jp-FileUploadIcon {
  background-image: var(--jp-icon-file-upload);
}

.jp-FilterDotIcon {
  background-image: var(--jp-icon-filter-dot);
}

.jp-FilterIcon {
  background-image: var(--jp-icon-filter);
}

.jp-FilterListIcon {
  background-image: var(--jp-icon-filter-list);
}

.jp-FolderFavoriteIcon {
  background-image: var(--jp-icon-folder-favorite);
}

.jp-FolderIcon {
  background-image: var(--jp-icon-folder);
}

.jp-HomeIcon {
  background-image: var(--jp-icon-home);
}

.jp-Html5Icon {
  background-image: var(--jp-icon-html5);
}

.jp-ImageIcon {
  background-image: var(--jp-icon-image);
}

.jp-InfoIcon {
  background-image: var(--jp-icon-info);
}

.jp-InspectorIcon {
  background-image: var(--jp-icon-inspector);
}

.jp-JsonIcon {
  background-image: var(--jp-icon-json);
}

.jp-JuliaIcon {
  background-image: var(--jp-icon-julia);
}

.jp-JupyterFaviconIcon {
  background-image: var(--jp-icon-jupyter-favicon);
}

.jp-JupyterIcon {
  background-image: var(--jp-icon-jupyter);
}

.jp-JupyterlabWordmarkIcon {
  background-image: var(--jp-icon-jupyterlab-wordmark);
}

.jp-KernelIcon {
  background-image: var(--jp-icon-kernel);
}

.jp-KeyboardIcon {
  background-image: var(--jp-icon-keyboard);
}

.jp-LaunchIcon {
  background-image: var(--jp-icon-launch);
}

.jp-LauncherIcon {
  background-image: var(--jp-icon-launcher);
}

.jp-LineFormIcon {
  background-image: var(--jp-icon-line-form);
}

.jp-LinkIcon {
  background-image: var(--jp-icon-link);
}

.jp-ListIcon {
  background-image: var(--jp-icon-list);
}

.jp-MarkdownIcon {
  background-image: var(--jp-icon-markdown);
}

.jp-MoveDownIcon {
  background-image: var(--jp-icon-move-down);
}

.jp-MoveUpIcon {
  background-image: var(--jp-icon-move-up);
}

.jp-NewFolderIcon {
  background-image: var(--jp-icon-new-folder);
}

.jp-NotTrustedIcon {
  background-image: var(--jp-icon-not-trusted);
}

.jp-NotebookIcon {
  background-image: var(--jp-icon-notebook);
}

.jp-NumberingIcon {
  background-image: var(--jp-icon-numbering);
}

.jp-OfflineBoltIcon {
  background-image: var(--jp-icon-offline-bolt);
}

.jp-PaletteIcon {
  background-image: var(--jp-icon-palette);
}

.jp-PasteIcon {
  background-image: var(--jp-icon-paste);
}

.jp-PdfIcon {
  background-image: var(--jp-icon-pdf);
}

.jp-PythonIcon {
  background-image: var(--jp-icon-python);
}

.jp-RKernelIcon {
  background-image: var(--jp-icon-r-kernel);
}

.jp-ReactIcon {
  background-image: var(--jp-icon-react);
}

.jp-RedoIcon {
  background-image: var(--jp-icon-redo);
}

.jp-RefreshIcon {
  background-image: var(--jp-icon-refresh);
}

.jp-RegexIcon {
  background-image: var(--jp-icon-regex);
}

.jp-RunIcon {
  background-image: var(--jp-icon-run);
}

.jp-RunningIcon {
  background-image: var(--jp-icon-running);
}

.jp-SaveIcon {
  background-image: var(--jp-icon-save);
}

.jp-SearchIcon {
  background-image: var(--jp-icon-search);
}

.jp-SettingsIcon {
  background-image: var(--jp-icon-settings);
}

.jp-ShareIcon {
  background-image: var(--jp-icon-share);
}

.jp-SpreadsheetIcon {
  background-image: var(--jp-icon-spreadsheet);
}

.jp-StopIcon {
  background-image: var(--jp-icon-stop);
}

.jp-TabIcon {
  background-image: var(--jp-icon-tab);
}

.jp-TableRowsIcon {
  background-image: var(--jp-icon-table-rows);
}

.jp-TagIcon {
  background-image: var(--jp-icon-tag);
}

.jp-TerminalIcon {
  background-image: var(--jp-icon-terminal);
}

.jp-TextEditorIcon {
  background-image: var(--jp-icon-text-editor);
}

.jp-TocIcon {
  background-image: var(--jp-icon-toc);
}

.jp-TreeViewIcon {
  background-image: var(--jp-icon-tree-view);
}

.jp-TrustedIcon {
  background-image: var(--jp-icon-trusted);
}

.jp-UndoIcon {
  background-image: var(--jp-icon-undo);
}

.jp-UserIcon {
  background-image: var(--jp-icon-user);
}

.jp-UsersIcon {
  background-image: var(--jp-icon-users);
}

.jp-VegaIcon {
  background-image: var(--jp-icon-vega);
}

.jp-WordIcon {
  background-image: var(--jp-icon-word);
}

.jp-YamlIcon {
  background-image: var(--jp-icon-yaml);
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/**
 * (DEPRECATED) Support for consuming icons as CSS background images
 */

.jp-Icon,
.jp-MaterialIcon {
  background-position: center;
  background-repeat: no-repeat;
  background-size: 16px;
  min-width: 16px;
  min-height: 16px;
}

.jp-Icon-cover {
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/**
 * (DEPRECATED) Support for specific CSS icon sizes
 */

.jp-Icon-16 {
  background-size: 16px;
  min-width: 16px;
  min-height: 16px;
}

.jp-Icon-18 {
  background-size: 18px;
  min-width: 18px;
  min-height: 18px;
}

.jp-Icon-20 {
  background-size: 20px;
  min-width: 20px;
  min-height: 20px;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.lm-TabBar .lm-TabBar-addButton {
  align-items: center;
  display: flex;
  padding: 4px;
  padding-bottom: 5px;
  margin-right: 1px;
  background-color: var(--jp-layout-color2);
}

.lm-TabBar .lm-TabBar-addButton:hover {
  background-color: var(--jp-layout-color1);
}

.lm-DockPanel-tabBar .lm-TabBar-tab {
  width: var(--jp-private-horizontal-tab-width);
}

.lm-DockPanel-tabBar .lm-TabBar-content {
  flex: unset;
}

.lm-DockPanel-tabBar[data-orientation='horizontal'] {
  flex: 1 1 auto;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/**
 * Support for icons as inline SVG HTMLElements
 */

/* recolor the primary elements of an icon */
.jp-icon0[fill] {
  fill: var(--jp-inverse-layout-color0);
}

.jp-icon1[fill] {
  fill: var(--jp-inverse-layout-color1);
}

.jp-icon2[fill] {
  fill: var(--jp-inverse-layout-color2);
}

.jp-icon3[fill] {
  fill: var(--jp-inverse-layout-color3);
}

.jp-icon4[fill] {
  fill: var(--jp-inverse-layout-color4);
}

.jp-icon0[stroke] {
  stroke: var(--jp-inverse-layout-color0);
}

.jp-icon1[stroke] {
  stroke: var(--jp-inverse-layout-color1);
}

.jp-icon2[stroke] {
  stroke: var(--jp-inverse-layout-color2);
}

.jp-icon3[stroke] {
  stroke: var(--jp-inverse-layout-color3);
}

.jp-icon4[stroke] {
  stroke: var(--jp-inverse-layout-color4);
}

/* recolor the accent elements of an icon */
.jp-icon-accent0[fill] {
  fill: var(--jp-layout-color0);
}

.jp-icon-accent1[fill] {
  fill: var(--jp-layout-color1);
}

.jp-icon-accent2[fill] {
  fill: var(--jp-layout-color2);
}

.jp-icon-accent3[fill] {
  fill: var(--jp-layout-color3);
}

.jp-icon-accent4[fill] {
  fill: var(--jp-layout-color4);
}

.jp-icon-accent0[stroke] {
  stroke: var(--jp-layout-color0);
}

.jp-icon-accent1[stroke] {
  stroke: var(--jp-layout-color1);
}

.jp-icon-accent2[stroke] {
  stroke: var(--jp-layout-color2);
}

.jp-icon-accent3[stroke] {
  stroke: var(--jp-layout-color3);
}

.jp-icon-accent4[stroke] {
  stroke: var(--jp-layout-color4);
}

/* set the color of an icon to transparent */
.jp-icon-none[fill] {
  fill: none;
}

.jp-icon-none[stroke] {
  stroke: none;
}

/* brand icon colors. Same for light and dark */
.jp-icon-brand0[fill] {
  fill: var(--jp-brand-color0);
}

.jp-icon-brand1[fill] {
  fill: var(--jp-brand-color1);
}

.jp-icon-brand2[fill] {
  fill: var(--jp-brand-color2);
}

.jp-icon-brand3[fill] {
  fill: var(--jp-brand-color3);
}

.jp-icon-brand4[fill] {
  fill: var(--jp-brand-color4);
}

.jp-icon-brand0[stroke] {
  stroke: var(--jp-brand-color0);
}

.jp-icon-brand1[stroke] {
  stroke: var(--jp-brand-color1);
}

.jp-icon-brand2[stroke] {
  stroke: var(--jp-brand-color2);
}

.jp-icon-brand3[stroke] {
  stroke: var(--jp-brand-color3);
}

.jp-icon-brand4[stroke] {
  stroke: var(--jp-brand-color4);
}

/* warn icon colors. Same for light and dark */
.jp-icon-warn0[fill] {
  fill: var(--jp-warn-color0);
}

.jp-icon-warn1[fill] {
  fill: var(--jp-warn-color1);
}

.jp-icon-warn2[fill] {
  fill: var(--jp-warn-color2);
}

.jp-icon-warn3[fill] {
  fill: var(--jp-warn-color3);
}

.jp-icon-warn0[stroke] {
  stroke: var(--jp-warn-color0);
}

.jp-icon-warn1[stroke] {
  stroke: var(--jp-warn-color1);
}

.jp-icon-warn2[stroke] {
  stroke: var(--jp-warn-color2);
}

.jp-icon-warn3[stroke] {
  stroke: var(--jp-warn-color3);
}

/* icon colors that contrast well with each other and most backgrounds */
.jp-icon-contrast0[fill] {
  fill: var(--jp-icon-contrast-color0);
}

.jp-icon-contrast1[fill] {
  fill: var(--jp-icon-contrast-color1);
}

.jp-icon-contrast2[fill] {
  fill: var(--jp-icon-contrast-color2);
}

.jp-icon-contrast3[fill] {
  fill: var(--jp-icon-contrast-color3);
}

.jp-icon-contrast0[stroke] {
  stroke: var(--jp-icon-contrast-color0);
}

.jp-icon-contrast1[stroke] {
  stroke: var(--jp-icon-contrast-color1);
}

.jp-icon-contrast2[stroke] {
  stroke: var(--jp-icon-contrast-color2);
}

.jp-icon-contrast3[stroke] {
  stroke: var(--jp-icon-contrast-color3);
}

.jp-icon-dot[fill] {
  fill: var(--jp-warn-color0);
}

.jp-jupyter-icon-color[fill] {
  fill: var(--jp-jupyter-icon-color, var(--jp-warn-color0));
}

.jp-notebook-icon-color[fill] {
  fill: var(--jp-notebook-icon-color, var(--jp-warn-color0));
}

.jp-json-icon-color[fill] {
  fill: var(--jp-json-icon-color, var(--jp-warn-color1));
}

.jp-console-icon-color[fill] {
  fill: var(--jp-console-icon-color, white);
}

.jp-console-icon-background-color[fill] {
  fill: var(--jp-console-icon-background-color, var(--jp-brand-color1));
}

.jp-terminal-icon-color[fill] {
  fill: var(--jp-terminal-icon-color, var(--jp-layout-color2));
}

.jp-terminal-icon-background-color[fill] {
  fill: var(
    --jp-terminal-icon-background-color,
    var(--jp-inverse-layout-color2)
  );
}

.jp-text-editor-icon-color[fill] {
  fill: var(--jp-text-editor-icon-color, var(--jp-inverse-layout-color3));
}

.jp-inspector-icon-color[fill] {
  fill: var(--jp-inspector-icon-color, var(--jp-inverse-layout-color3));
}

/* CSS for icons in selected filebrowser listing items */
.jp-DirListing-item.jp-mod-selected .jp-icon-selectable[fill] {
  fill: #fff;
}

.jp-DirListing-item.jp-mod-selected .jp-icon-selectable-inverse[fill] {
  fill: var(--jp-brand-color1);
}

/* stylelint-disable selector-max-class, selector-max-compound-selectors */

/**
* TODO: come up with non css-hack solution for showing the busy icon on top
*  of the close icon
* CSS for complex behavior of close icon of tabs in the main area tabbar
*/
.lm-DockPanel-tabBar
  .lm-TabBar-tab.lm-mod-closable.jp-mod-dirty
  > .lm-TabBar-tabCloseIcon
  > :not(:hover)
  > .jp-icon3[fill] {
  fill: none;
}

.lm-DockPanel-tabBar
  .lm-TabBar-tab.lm-mod-closable.jp-mod-dirty
  > .lm-TabBar-tabCloseIcon
  > :not(:hover)
  > .jp-icon-busy[fill] {
  fill: var(--jp-inverse-layout-color3);
}

/* stylelint-enable selector-max-class, selector-max-compound-selectors */

/* CSS for icons in status bar */
#jp-main-statusbar .jp-mod-selected .jp-icon-selectable[fill] {
  fill: #fff;
}

#jp-main-statusbar .jp-mod-selected .jp-icon-selectable-inverse[fill] {
  fill: var(--jp-brand-color1);
}

/* special handling for splash icon CSS. While the theme CSS reloads during
   splash, the splash icon can loose theming. To prevent that, we set a
   default for its color variable */
:root {
  --jp-warn-color0: var(--md-orange-700);
}

/* not sure what to do with this one, used in filebrowser listing */
.jp-DragIcon {
  margin-right: 4px;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/**
 * Support for alt colors for icons as inline SVG HTMLElements
 */

/* alt recolor the primary elements of an icon */
.jp-icon-alt .jp-icon0[fill] {
  fill: var(--jp-layout-color0);
}

.jp-icon-alt .jp-icon1[fill] {
  fill: var(--jp-layout-color1);
}

.jp-icon-alt .jp-icon2[fill] {
  fill: var(--jp-layout-color2);
}

.jp-icon-alt .jp-icon3[fill] {
  fill: var(--jp-layout-color3);
}

.jp-icon-alt .jp-icon4[fill] {
  fill: var(--jp-layout-color4);
}

.jp-icon-alt .jp-icon0[stroke] {
  stroke: var(--jp-layout-color0);
}

.jp-icon-alt .jp-icon1[stroke] {
  stroke: var(--jp-layout-color1);
}

.jp-icon-alt .jp-icon2[stroke] {
  stroke: var(--jp-layout-color2);
}

.jp-icon-alt .jp-icon3[stroke] {
  stroke: var(--jp-layout-color3);
}

.jp-icon-alt .jp-icon4[stroke] {
  stroke: var(--jp-layout-color4);
}

/* alt recolor the accent elements of an icon */
.jp-icon-alt .jp-icon-accent0[fill] {
  fill: var(--jp-inverse-layout-color0);
}

.jp-icon-alt .jp-icon-accent1[fill] {
  fill: var(--jp-inverse-layout-color1);
}

.jp-icon-alt .jp-icon-accent2[fill] {
  fill: var(--jp-inverse-layout-color2);
}

.jp-icon-alt .jp-icon-accent3[fill] {
  fill: var(--jp-inverse-layout-color3);
}

.jp-icon-alt .jp-icon-accent4[fill] {
  fill: var(--jp-inverse-layout-color4);
}

.jp-icon-alt .jp-icon-accent0[stroke] {
  stroke: var(--jp-inverse-layout-color0);
}

.jp-icon-alt .jp-icon-accent1[stroke] {
  stroke: var(--jp-inverse-layout-color1);
}

.jp-icon-alt .jp-icon-accent2[stroke] {
  stroke: var(--jp-inverse-layout-color2);
}

.jp-icon-alt .jp-icon-accent3[stroke] {
  stroke: var(--jp-inverse-layout-color3);
}

.jp-icon-alt .jp-icon-accent4[stroke] {
  stroke: var(--jp-inverse-layout-color4);
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-icon-hoverShow:not(:hover) .jp-icon-hoverShow-content {
  display: none !important;
}

/**
 * Support for hover colors for icons as inline SVG HTMLElements
 */

/**
 * regular colors
 */

/* recolor the primary elements of an icon */
.jp-icon-hover :hover .jp-icon0-hover[fill] {
  fill: var(--jp-inverse-layout-color0);
}

.jp-icon-hover :hover .jp-icon1-hover[fill] {
  fill: var(--jp-inverse-layout-color1);
}

.jp-icon-hover :hover .jp-icon2-hover[fill] {
  fill: var(--jp-inverse-layout-color2);
}

.jp-icon-hover :hover .jp-icon3-hover[fill] {
  fill: var(--jp-inverse-layout-color3);
}

.jp-icon-hover :hover .jp-icon4-hover[fill] {
  fill: var(--jp-inverse-layout-color4);
}

.jp-icon-hover :hover .jp-icon0-hover[stroke] {
  stroke: var(--jp-inverse-layout-color0);
}

.jp-icon-hover :hover .jp-icon1-hover[stroke] {
  stroke: var(--jp-inverse-layout-color1);
}

.jp-icon-hover :hover .jp-icon2-hover[stroke] {
  stroke: var(--jp-inverse-layout-color2);
}

.jp-icon-hover :hover .jp-icon3-hover[stroke] {
  stroke: var(--jp-inverse-layout-color3);
}

.jp-icon-hover :hover .jp-icon4-hover[stroke] {
  stroke: var(--jp-inverse-layout-color4);
}

/* recolor the accent elements of an icon */
.jp-icon-hover :hover .jp-icon-accent0-hover[fill] {
  fill: var(--jp-layout-color0);
}

.jp-icon-hover :hover .jp-icon-accent1-hover[fill] {
  fill: var(--jp-layout-color1);
}

.jp-icon-hover :hover .jp-icon-accent2-hover[fill] {
  fill: var(--jp-layout-color2);
}

.jp-icon-hover :hover .jp-icon-accent3-hover[fill] {
  fill: var(--jp-layout-color3);
}

.jp-icon-hover :hover .jp-icon-accent4-hover[fill] {
  fill: var(--jp-layout-color4);
}

.jp-icon-hover :hover .jp-icon-accent0-hover[stroke] {
  stroke: var(--jp-layout-color0);
}

.jp-icon-hover :hover .jp-icon-accent1-hover[stroke] {
  stroke: var(--jp-layout-color1);
}

.jp-icon-hover :hover .jp-icon-accent2-hover[stroke] {
  stroke: var(--jp-layout-color2);
}

.jp-icon-hover :hover .jp-icon-accent3-hover[stroke] {
  stroke: var(--jp-layout-color3);
}

.jp-icon-hover :hover .jp-icon-accent4-hover[stroke] {
  stroke: var(--jp-layout-color4);
}

/* set the color of an icon to transparent */
.jp-icon-hover :hover .jp-icon-none-hover[fill] {
  fill: none;
}

.jp-icon-hover :hover .jp-icon-none-hover[stroke] {
  stroke: none;
}

/**
 * inverse colors
 */

/* inverse recolor the primary elements of an icon */
.jp-icon-hover.jp-icon-alt :hover .jp-icon0-hover[fill] {
  fill: var(--jp-layout-color0);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon1-hover[fill] {
  fill: var(--jp-layout-color1);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon2-hover[fill] {
  fill: var(--jp-layout-color2);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon3-hover[fill] {
  fill: var(--jp-layout-color3);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon4-hover[fill] {
  fill: var(--jp-layout-color4);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon0-hover[stroke] {
  stroke: var(--jp-layout-color0);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon1-hover[stroke] {
  stroke: var(--jp-layout-color1);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon2-hover[stroke] {
  stroke: var(--jp-layout-color2);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon3-hover[stroke] {
  stroke: var(--jp-layout-color3);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon4-hover[stroke] {
  stroke: var(--jp-layout-color4);
}

/* inverse recolor the accent elements of an icon */
.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent0-hover[fill] {
  fill: var(--jp-inverse-layout-color0);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent1-hover[fill] {
  fill: var(--jp-inverse-layout-color1);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent2-hover[fill] {
  fill: var(--jp-inverse-layout-color2);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent3-hover[fill] {
  fill: var(--jp-inverse-layout-color3);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent4-hover[fill] {
  fill: var(--jp-inverse-layout-color4);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent0-hover[stroke] {
  stroke: var(--jp-inverse-layout-color0);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent1-hover[stroke] {
  stroke: var(--jp-inverse-layout-color1);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent2-hover[stroke] {
  stroke: var(--jp-inverse-layout-color2);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent3-hover[stroke] {
  stroke: var(--jp-inverse-layout-color3);
}

.jp-icon-hover.jp-icon-alt :hover .jp-icon-accent4-hover[stroke] {
  stroke: var(--jp-inverse-layout-color4);
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-IFrame {
  width: 100%;
  height: 100%;
}

.jp-IFrame > iframe {
  border: none;
}

/*
When drag events occur, `lm-mod-override-cursor` is added to the body.
Because iframes steal all cursor events, the following two rules are necessary
to suppress pointer events while resize drags are occurring. There may be a
better solution to this problem.
*/
body.lm-mod-override-cursor .jp-IFrame {
  position: relative;
}

body.lm-mod-override-cursor .jp-IFrame::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: transparent;
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2014-2016, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-HoverBox {
  position: fixed;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-FormGroup-content fieldset {
  border: none;
  padding: 0;
  min-width: 0;
  width: 100%;
}

/* stylelint-disable selector-max-type */

.jp-FormGroup-content fieldset .jp-inputFieldWrapper input,
.jp-FormGroup-content fieldset .jp-inputFieldWrapper select,
.jp-FormGroup-content fieldset .jp-inputFieldWrapper textarea {
  font-size: var(--jp-content-font-size2);
  border-color: var(--jp-input-border-color);
  border-style: solid;
  border-radius: var(--jp-border-radius);
  border-width: 1px;
  padding: 6px 8px;
  background: none;
  color: var(--jp-ui-font-color0);
  height: inherit;
}

.jp-FormGroup-content fieldset input[type='checkbox'] {
  position: relative;
  top: 2px;
  margin-left: 0;
}

.jp-FormGroup-content button.jp-mod-styled {
  cursor: pointer;
}

.jp-FormGroup-content .checkbox label {
  cursor: pointer;
  font-size: var(--jp-content-font-size1);
}

.jp-FormGroup-content .jp-root > fieldset > legend {
  display: none;
}

.jp-FormGroup-content .jp-root > fieldset > p {
  display: none;
}

/** copy of `input.jp-mod-styled:focus` style */
.jp-FormGroup-content fieldset input:focus,
.jp-FormGroup-content fieldset select:focus {
  -moz-outline-radius: unset;
  outline: var(--jp-border-width) solid var(--md-blue-500);
  outline-offset: -1px;
  box-shadow: inset 0 0 4px var(--md-blue-300);
}

.jp-FormGroup-content fieldset input:hover:not(:focus),
.jp-FormGroup-content fieldset select:hover:not(:focus) {
  background-color: var(--jp-border-color2);
}

/* stylelint-enable selector-max-type */

.jp-FormGroup-content .checkbox .field-description {
  /* Disable default description field for checkbox:
   because other widgets do not have description fields,
   we add descriptions to each widget on the field level.
  */
  display: none;
}

.jp-FormGroup-content #root__description {
  display: none;
}

.jp-FormGroup-content .jp-modifiedIndicator {
  width: 5px;
  background-color: var(--jp-brand-color2);
  margin-top: 0;
  margin-left: calc(var(--jp-private-settingeditor-modifier-indent) * -1);
  flex-shrink: 0;
}

.jp-FormGroup-content .jp-modifiedIndicator.jp-errorIndicator {
  background-color: var(--jp-error-color0);
  margin-right: 0.5em;
}

/* RJSF ARRAY style */

.jp-arrayFieldWrapper legend {
  font-size: var(--jp-content-font-size2);
  color: var(--jp-ui-font-color0);
  flex-basis: 100%;
  padding: 4px 0;
  font-weight: var(--jp-content-heading-font-weight);
  border-bottom: 1px solid var(--jp-border-color2);
}

.jp-arrayFieldWrapper .field-description {
  padding: 4px 0;
  white-space: pre-wrap;
}

.jp-arrayFieldWrapper .array-item {
  width: 100%;
  border: 1px solid var(--jp-border-color2);
  border-radius: 4px;
  margin: 4px;
}

.jp-ArrayOperations {
  display: flex;
  margin-left: 8px;
}

.jp-ArrayOperationsButton {
  margin: 2px;
}

.jp-ArrayOperationsButton .jp-icon3[fill] {
  fill: var(--jp-ui-font-color0);
}

button.jp-ArrayOperationsButton.jp-mod-styled:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

/* RJSF form validation error */

.jp-FormGroup-content .validationErrors {
  color: var(--jp-error-color0);
}

/* Hide panel level error as duplicated the field level error */
.jp-FormGroup-content .panel.errors {
  display: none;
}

/* RJSF normal content (settings-editor) */

.jp-FormGroup-contentNormal {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}

.jp-FormGroup-contentNormal .jp-FormGroup-contentItem {
  margin-left: 7px;
  color: var(--jp-ui-font-color0);
}

.jp-FormGroup-contentNormal .jp-FormGroup-description {
  flex-basis: 100%;
  padding: 4px 7px;
}

.jp-FormGroup-contentNormal .jp-FormGroup-default {
  flex-basis: 100%;
  padding: 4px 7px;
}

.jp-FormGroup-contentNormal .jp-FormGroup-fieldLabel {
  font-size: var(--jp-content-font-size1);
  font-weight: normal;
  min-width: 120px;
}

.jp-FormGroup-contentNormal fieldset:not(:first-child) {
  margin-left: 7px;
}

.jp-FormGroup-contentNormal .field-array-of-string .array-item {
  /* Display `jp-ArrayOperations` buttons side-by-side with content except
    for small screens where flex-wrap will place them one below the other.
  */
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}

.jp-FormGroup-contentNormal .jp-objectFieldWrapper .form-group {
  padding: 2px 8px 2px var(--jp-private-settingeditor-modifier-indent);
  margin-top: 2px;
}

/* RJSF compact content (metadata-form) */

.jp-FormGroup-content.jp-FormGroup-contentCompact {
  width: 100%;
}

.jp-FormGroup-contentCompact .form-group {
  display: flex;
  padding: 0.5em 0.2em 0.5em 0;
}

.jp-FormGroup-contentCompact
  .jp-FormGroup-compactTitle
  .jp-FormGroup-description {
  font-size: var(--jp-ui-font-size1);
  color: var(--jp-ui-font-color2);
}

.jp-FormGroup-contentCompact .jp-FormGroup-fieldLabel {
  padding-bottom: 0.3em;
}

.jp-FormGroup-contentCompact .jp-inputFieldWrapper .form-control {
  width: 100%;
  box-sizing: border-box;
}

.jp-FormGroup-contentCompact .jp-arrayFieldWrapper .jp-FormGroup-compactTitle {
  padding-bottom: 7px;
}

.jp-FormGroup-contentCompact
  .jp-objectFieldWrapper
  .jp-objectFieldWrapper
  .form-group {
  padding: 2px 8px 2px var(--jp-private-settingeditor-modifier-indent);
  margin-top: 2px;
}

.jp-FormGroup-contentCompact ul.error-detail {
  margin-block-start: 0.5em;
  margin-block-end: 0.5em;
  padding-inline-start: 1em;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

.jp-SidePanel {
  display: flex;
  flex-direction: column;
  min-width: var(--jp-sidebar-min-width);
  overflow-y: auto;
  color: var(--jp-ui-font-color1);
  background: var(--jp-layout-color1);
  font-size: var(--jp-ui-font-size1);
}

.jp-SidePanel-header {
  flex: 0 0 auto;
  display: flex;
  border-bottom: var(--jp-border-width) solid var(--jp-border-color2);
  font-size: var(--jp-ui-font-size0);
  font-weight: 600;
  letter-spacing: 1px;
  margin: 0;
  padding: 2px;
  text-transform: uppercase;
}

.jp-SidePanel-toolbar {
  flex: 0 0 auto;
}

.jp-SidePanel-content {
  flex: 1 1 auto;
}

.jp-SidePanel-toolbar,
.jp-AccordionPanel-toolbar {
  height: var(--jp-private-toolbar-height);
}

.jp-SidePanel-toolbar.jp-Toolbar-micro {
  display: none;
}

.lm-AccordionPanel .jp-AccordionPanel-title {
  box-sizing: border-box;
  line-height: 25px;
  margin: 0;
  display: flex;
  align-items: center;
  background: var(--jp-layout-color1);
  color: var(--jp-ui-font-color1);
  border-bottom: var(--jp-border-width) solid var(--jp-toolbar-border-color);
  box-shadow: var(--jp-toolbar-box-shadow);
  font-size: var(--jp-ui-font-size0);
}

.jp-AccordionPanel-title {
  cursor: pointer;
  user-select: none;
  -moz-user-select: none;
  -webkit-user-select: none;
  text-transform: uppercase;
}

.lm-AccordionPanel[data-orientation='horizontal'] > .jp-AccordionPanel-title {
  /* Title is rotated for horizontal accordion panel using CSS */
  display: block;
  transform-origin: top left;
  transform: rotate(-90deg) translate(-100%);
}

.jp-AccordionPanel-title .lm-AccordionPanel-titleLabel {
  user-select: none;
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}

.jp-AccordionPanel-title .lm-AccordionPanel-titleCollapser {
  transform: rotate(-90deg);
  margin: auto 0;
  height: 16px;
}

.jp-AccordionPanel-title.lm-mod-expanded .lm-AccordionPanel-titleCollapser {
  transform: rotate(0deg);
}

.lm-AccordionPanel .jp-AccordionPanel-toolbar {
  background: none;
  box-shadow: none;
  border: none;
  margin-left: auto;
}

.lm-AccordionPanel .lm-SplitPanel-handle:hover {
  background: var(--jp-layout-color3);
}

.jp-text-truncated {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2017, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-Spinner {
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 10;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: var(--jp-layout-color0);
  outline: none;
}

.jp-SpinnerContent {
  font-size: 10px;
  margin: 50px auto;
  text-indent: -9999em;
  width: 3em;
  height: 3em;
  border-radius: 50%;
  background: var(--jp-brand-color3);
  background: linear-gradient(
    to right,
    #f37626 10%,
    rgba(255, 255, 255, 0) 42%
  );
  position: relative;
  animation: load3 1s infinite linear, fadeIn 1s;
}

.jp-SpinnerContent::before {
  width: 50%;
  height: 50%;
  background: #f37626;
  border-radius: 100% 0 0;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
}

.jp-SpinnerContent::after {
  background: var(--jp-layout-color0);
  width: 75%;
  height: 75%;
  border-radius: 50%;
  content: '';
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

@keyframes fadeIn {
  0% {
    opacity: 0;
  }

  100% {
    opacity: 1;
  }
}

@keyframes load3 {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2014-2017, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

button.jp-mod-styled {
  font-size: var(--jp-ui-font-size1);
  color: var(--jp-ui-font-color0);
  border: none;
  box-sizing: border-box;
  text-align: center;
  line-height: 32px;
  height: 32px;
  padding: 0 12px;
  letter-spacing: 0.8px;
  outline: none;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

input.jp-mod-styled {
  background: var(--jp-input-background);
  height: 28px;
  box-sizing: border-box;
  border: var(--jp-border-width) solid var(--jp-border-color1);
  padding-left: 7px;
  padding-right: 7px;
  font-size: var(--jp-ui-font-size2);
  color: var(--jp-ui-font-color0);
  outline: none;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

input[type='checkbox'].jp-mod-styled {
  appearance: checkbox;
  -webkit-appearance: checkbox;
  -moz-appearance: checkbox;
  height: auto;
}

input.jp-mod-styled:focus {
  border: var(--jp-border-width) solid var(--md-blue-500);
  box-shadow: inset 0 0 4px var(--md-blue-300);
}

.jp-select-wrapper {
  display: flex;
  position: relative;
  flex-direction: column;
  padding: 1px;
  background-color: var(--jp-layout-color1);
  box-sizing: border-box;
  margin-bottom: 12px;
}

.jp-select-wrapper:not(.multiple) {
  height: 28px;
}

.jp-select-wrapper.jp-mod-focused select.jp-mod-styled {
  border: var(--jp-border-width) solid var(--jp-input-active-border-color);
  box-shadow: var(--jp-input-box-shadow);
  background-color: var(--jp-input-active-background);
}

select.jp-mod-styled:hover {
  cursor: pointer;
  color: var(--jp-ui-font-color0);
  background-color: var(--jp-input-hover-background);
  box-shadow: inset 0 0 1px rgba(0, 0, 0, 0.5);
}

select.jp-mod-styled {
  flex: 1 1 auto;
  width: 100%;
  font-size: var(--jp-ui-font-size2);
  background: var(--jp-input-background);
  color: var(--jp-ui-font-color0);
  padding: 0 25px 0 8px;
  border: var(--jp-border-width) solid var(--jp-input-border-color);
  border-radius: 0;
  outline: none;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

select.jp-mod-styled:not([multiple]) {
  height: 32px;
}

select.jp-mod-styled[multiple] {
  max-height: 200px;
  overflow-y: auto;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-switch {
  display: flex;
  align-items: center;
  padding-left: 4px;
  padding-right: 4px;
  font-size: var(--jp-ui-font-size1);
  background-color: transparent;
  color: var(--jp-ui-font-color1);
  border: none;
  height: 20px;
}

.jp-switch:hover {
  background-color: var(--jp-layout-color2);
}

.jp-switch-label {
  margin-right: 5px;
  font-family: var(--jp-ui-font-family);
}

.jp-switch-track {
  cursor: pointer;
  background-color: var(--jp-switch-color, var(--jp-border-color1));
  -webkit-transition: 0.4s;
  transition: 0.4s;
  border-radius: 34px;
  height: 16px;
  width: 35px;
  position: relative;
}

.jp-switch-track::before {
  content: '';
  position: absolute;
  height: 10px;
  width: 10px;
  margin: 3px;
  left: 0;
  background-color: var(--jp-ui-inverse-font-color1);
  -webkit-transition: 0.4s;
  transition: 0.4s;
  border-radius: 50%;
}

.jp-switch[aria-checked='true'] .jp-switch-track {
  background-color: var(--jp-switch-true-position-color, var(--jp-warn-color0));
}

.jp-switch[aria-checked='true'] .jp-switch-track::before {
  /* track width (35) - margins (3 + 3) - thumb width (10) */
  left: 19px;
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2014-2016, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

:root {
  --jp-private-toolbar-height: calc(
    28px + var(--jp-border-width)
  ); /* leave 28px for content */
}

.jp-Toolbar {
  color: var(--jp-ui-font-color1);
  flex: 0 0 auto;
  display: flex;
  flex-direction: row;
  border-bottom: var(--jp-border-width) solid var(--jp-toolbar-border-color);
  box-shadow: var(--jp-toolbar-box-shadow);
  background: var(--jp-toolbar-background);
  min-height: var(--jp-toolbar-micro-height);
  padding: 2px;
  z-index: 8;
  overflow-x: hidden;
}

/* Toolbar items */

.jp-Toolbar > .jp-Toolbar-item.jp-Toolbar-spacer {
  flex-grow: 1;
  flex-shrink: 1;
}

.jp-Toolbar-item.jp-Toolbar-kernelStatus {
  display: inline-block;
  width: 32px;
  background-repeat: no-repeat;
  background-position: center;
  background-size: 16px;
}

.jp-Toolbar > .jp-Toolbar-item {
  flex: 0 0 auto;
  display: flex;
  padding-left: 1px;
  padding-right: 1px;
  font-size: var(--jp-ui-font-size1);
  line-height: var(--jp-private-toolbar-height);
  height: 100%;
}

/* Toolbar buttons */

/* This is the div we use to wrap the react component into a Widget */
div.jp-ToolbarButton {
  color: transparent;
  border: none;
  box-sizing: border-box;
  outline: none;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 0;
  margin: 0;
}

button.jp-ToolbarButtonComponent {
  background: var(--jp-layout-color1);
  border: none;
  box-sizing: border-box;
  outline: none;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 0 6px;
  margin: 0;
  height: 24px;
  border-radius: var(--jp-border-radius);
  display: flex;
  align-items: center;
  text-align: center;
  font-size: 14px;
  min-width: unset;
  min-height: unset;
}

button.jp-ToolbarButtonComponent:disabled {
  opacity: 0.4;
}

button.jp-ToolbarButtonComponent > span {
  padding: 0;
  flex: 0 0 auto;
}

button.jp-ToolbarButtonComponent .jp-ToolbarButtonComponent-label {
  font-size: var(--jp-ui-font-size1);
  line-height: 100%;
  padding-left: 2px;
  color: var(--jp-ui-font-color1);
  font-family: var(--jp-ui-font-family);
}

#jp-main-dock-panel[data-mode='single-document']
  .jp-MainAreaWidget
  > .jp-Toolbar.jp-Toolbar-micro {
  padding: 0;
  min-height: 0;
}

#jp-main-dock-panel[data-mode='single-document']
  .jp-MainAreaWidget
  > .jp-Toolbar {
  border: none;
  box-shadow: none;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

.jp-WindowedPanel-outer {
  position: relative;
  overflow-y: auto;
}

.jp-WindowedPanel-inner {
  position: relative;
}

.jp-WindowedPanel-window {
  position: absolute;
  left: 0;
  right: 0;
  overflow: visible;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/* Sibling imports */

body {
  color: var(--jp-ui-font-color1);
  font-size: var(--jp-ui-font-size1);
}

/* Disable native link decoration styles everywhere outside of dialog boxes */
a {
  text-decoration: unset;
  color: unset;
}

a:hover {
  text-decoration: unset;
  color: unset;
}

/* Accessibility for links inside dialog box text */
.jp-Dialog-content a {
  text-decoration: revert;
  color: var(--jp-content-link-color);
}

.jp-Dialog-content a:hover {
  text-decoration: revert;
}

/* Styles for ui-components */
.jp-Button {
  color: var(--jp-ui-font-color2);
  border-radius: var(--jp-border-radius);
  padding: 0 12px;
  font-size: var(--jp-ui-font-size1);

  /* Copy from blueprint 3 */
  display: inline-flex;
  flex-direction: row;
  border: none;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  text-align: left;
  vertical-align: middle;
  min-height: 30px;
  min-width: 30px;
}

.jp-Button:disabled {
  cursor: not-allowed;
}

.jp-Button:empty {
  padding: 0 !important;
}

.jp-Button.jp-mod-small {
  min-height: 24px;
  min-width: 24px;
  font-size: 12px;
  padding: 0 7px;
}

/* Use our own theme for hover styles */
.jp-Button.jp-mod-minimal:hover {
  background-color: var(--jp-layout-color2);
}

.jp-Button.jp-mod-minimal {
  background: none;
}

.jp-InputGroup {
  display: block;
  position: relative;
}

.jp-InputGroup input {
  box-sizing: border-box;
  border: none;
  border-radius: 0;
  background-color: transparent;
  color: var(--jp-ui-font-color0);
  box-shadow: inset 0 0 0 var(--jp-border-width) var(--jp-input-border-color);
  padding-bottom: 0;
  padding-top: 0;
  padding-left: 10px;
  padding-right: 28px;
  position: relative;
  width: 100%;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  font-size: 14px;
  font-weight: 400;
  height: 30px;
  line-height: 30px;
  outline: none;
  vertical-align: middle;
}

.jp-InputGroup input:focus {
  box-shadow: inset 0 0 0 var(--jp-border-width)
      var(--jp-input-active-box-shadow-color),
    inset 0 0 0 3px var(--jp-input-active-box-shadow-color);
}

.jp-InputGroup input:disabled {
  cursor: not-allowed;
  resize: block;
  background-color: var(--jp-layout-color2);
  color: var(--jp-ui-font-color2);
}

.jp-InputGroup input:disabled ~ span {
  cursor: not-allowed;
  color: var(--jp-ui-font-color2);
}

.jp-InputGroup input::placeholder,
input::placeholder {
  color: var(--jp-ui-font-color2);
}

.jp-InputGroupAction {
  position: absolute;
  bottom: 1px;
  right: 0;
  padding: 6px;
}

.jp-HTMLSelect.jp-DefaultStyle select {
  background-color: initial;
  border: none;
  border-radius: 0;
  box-shadow: none;
  color: var(--jp-ui-font-color0);
  display: block;
  font-size: var(--jp-ui-font-size1);
  font-family: var(--jp-ui-font-family);
  height: 24px;
  line-height: 14px;
  padding: 0 25px 0 10px;
  text-align: left;
  -moz-appearance: none;
  -webkit-appearance: none;
}

.jp-HTMLSelect.jp-DefaultStyle select:disabled {
  background-color: var(--jp-layout-color2);
  color: var(--jp-ui-font-color2);
  cursor: not-allowed;
  resize: block;
}

.jp-HTMLSelect.jp-DefaultStyle select:disabled ~ span {
  cursor: not-allowed;
}

/* Use our own theme for hover and option styles */
/* stylelint-disable-next-line selector-max-type */
.jp-HTMLSelect.jp-DefaultStyle select:hover,
.jp-HTMLSelect.jp-DefaultStyle select > option {
  background-color: var(--jp-layout-color2);
  color: var(--jp-ui-font-color0);
}

select {
  box-sizing: border-box;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Styles
|----------------------------------------------------------------------------*/

.jp-StatusBar-Widget {
  display: flex;
  align-items: center;
  background: var(--jp-layout-color2);
  min-height: var(--jp-statusbar-height);
  justify-content: space-between;
  padding: 0 10px;
}

.jp-StatusBar-Left {
  display: flex;
  align-items: center;
  flex-direction: row;
}

.jp-StatusBar-Middle {
  display: flex;
  align-items: center;
}

.jp-StatusBar-Right {
  display: flex;
  align-items: center;
  flex-direction: row-reverse;
}

.jp-StatusBar-Item {
  max-height: var(--jp-statusbar-height);
  margin: 0 2px;
  height: var(--jp-statusbar-height);
  white-space: nowrap;
  text-overflow: ellipsis;
  color: var(--jp-ui-font-color1);
  padding: 0 6px;
}

.jp-mod-highlighted:hover {
  background-color: var(--jp-layout-color3);
}

.jp-mod-clicked {
  background-color: var(--jp-brand-color1);
}

.jp-mod-clicked:hover {
  background-color: var(--jp-brand-color0);
}

.jp-mod-clicked .jp-StatusBar-TextItem {
  color: var(--jp-ui-inverse-font-color1);
}

.jp-StatusBar-HoverItem {
  box-shadow: '0px 4px 4px rgba(0, 0, 0, 0.25)';
}

.jp-StatusBar-TextItem {
  font-size: var(--jp-ui-font-size1);
  font-family: var(--jp-ui-font-family);
  line-height: 24px;
  color: var(--jp-ui-font-color1);
}

.jp-StatusBar-GroupItem {
  display: flex;
  align-items: center;
  flex-direction: row;
}

.jp-Statusbar-ProgressCircle svg {
  display: block;
  margin: 0 auto;
  width: 16px;
  height: 24px;
  align-self: normal;
}

.jp-Statusbar-ProgressCircle path {
  fill: var(--jp-inverse-layout-color3);
}

.jp-Statusbar-ProgressBar-progress-bar {
  height: 10px;
  width: 100px;
  border: solid 0.25px var(--jp-brand-color2);
  border-radius: 3px;
  overflow: hidden;
  align-self: center;
}

.jp-Statusbar-ProgressBar-progress-bar > div {
  background-color: var(--jp-brand-color2);
  background-image: linear-gradient(
    -45deg,
    rgba(255, 255, 255, 0.2) 25%,
    transparent 25%,
    transparent 50%,
    rgba(255, 255, 255, 0.2) 50%,
    rgba(255, 255, 255, 0.2) 75%,
    transparent 75%,
    transparent
  );
  background-size: 40px 40px;
  float: left;
  width: 0%;
  height: 100%;
  font-size: 12px;
  line-height: 14px;
  color: #fff;
  text-align: center;
  animation: jp-Statusbar-ExecutionTime-progress-bar 2s linear infinite;
}

.jp-Statusbar-ProgressBar-progress-bar p {
  color: var(--jp-ui-font-color1);
  font-family: var(--jp-ui-font-family);
  font-size: var(--jp-ui-font-size1);
  line-height: 10px;
  width: 100px;
}

@keyframes jp-Statusbar-ExecutionTime-progress-bar {
  0% {
    background-position: 0 0;
  }

  100% {
    background-position: 40px 40px;
  }
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Variables
|----------------------------------------------------------------------------*/

:root {
  --jp-private-commandpalette-search-height: 28px;
}

/*-----------------------------------------------------------------------------
| Overall styles
|----------------------------------------------------------------------------*/

.lm-CommandPalette {
  padding-bottom: 0;
  color: var(--jp-ui-font-color1);
  background: var(--jp-layout-color1);

  /* This is needed so that all font sizing of children done in ems is
   * relative to this base size */
  font-size: var(--jp-ui-font-size1);
}

/*-----------------------------------------------------------------------------
| Modal variant
|----------------------------------------------------------------------------*/

.jp-ModalCommandPalette {
  position: absolute;
  z-index: 10000;
  top: 38px;
  left: 30%;
  margin: 0;
  padding: 4px;
  width: 40%;
  box-shadow: var(--jp-elevation-z4);
  border-radius: 4px;
  background: var(--jp-layout-color0);
}

.jp-ModalCommandPalette .lm-CommandPalette {
  max-height: 40vh;
}

.jp-ModalCommandPalette .lm-CommandPalette .lm-close-icon::after {
  display: none;
}

.jp-ModalCommandPalette .lm-CommandPalette .lm-CommandPalette-header {
  display: none;
}

.jp-ModalCommandPalette .lm-CommandPalette .lm-CommandPalette-item {
  margin-left: 4px;
  margin-right: 4px;
}

.jp-ModalCommandPalette
  .lm-CommandPalette
  .lm-CommandPalette-item.lm-mod-disabled {
  display: none;
}

/*-----------------------------------------------------------------------------
| Search
|----------------------------------------------------------------------------*/

.lm-CommandPalette-search {
  padding: 4px;
  background-color: var(--jp-layout-color1);
  z-index: 2;
}

.lm-CommandPalette-wrapper {
  overflow: overlay;
  padding: 0 9px;
  background-color: var(--jp-input-active-background);
  height: 30px;
  box-shadow: inset 0 0 0 var(--jp-border-width) var(--jp-input-border-color);
}

.lm-CommandPalette.lm-mod-focused .lm-CommandPalette-wrapper {
  box-shadow: inset 0 0 0 1px var(--jp-input-active-box-shadow-color),
    inset 0 0 0 3px var(--jp-input-active-box-shadow-color);
}

.jp-SearchIconGroup {
  color: white;
  background-color: var(--jp-brand-color1);
  position: absolute;
  top: 4px;
  right: 4px;
  padding: 5px 5px 1px;
}

.jp-SearchIconGroup svg {
  height: 20px;
  width: 20px;
}

.jp-SearchIconGroup .jp-icon3[fill] {
  fill: var(--jp-layout-color0);
}

.lm-CommandPalette-input {
  background: transparent;
  width: calc(100% - 18px);
  float: left;
  border: none;
  outline: none;
  font-size: var(--jp-ui-font-size1);
  color: var(--jp-ui-font-color0);
  line-height: var(--jp-private-commandpalette-search-height);
}

.lm-CommandPalette-input::-webkit-input-placeholder,
.lm-CommandPalette-input::-moz-placeholder,
.lm-CommandPalette-input:-ms-input-placeholder {
  color: var(--jp-ui-font-color2);
  font-size: var(--jp-ui-font-size1);
}

/*-----------------------------------------------------------------------------
| Results
|----------------------------------------------------------------------------*/

.lm-CommandPalette-header:first-child {
  margin-top: 0;
}

.lm-CommandPalette-header {
  border-bottom: solid var(--jp-border-width) var(--jp-border-color2);
  color: var(--jp-ui-font-color1);
  cursor: pointer;
  display: flex;
  font-size: var(--jp-ui-font-size0);
  font-weight: 600;
  letter-spacing: 1px;
  margin-top: 8px;
  padding: 8px 0 8px 12px;
  text-transform: uppercase;
}

.lm-CommandPalette-header.lm-mod-active {
  background: var(--jp-layout-color2);
}

.lm-CommandPalette-header > mark {
  background-color: transparent;
  font-weight: bold;
  color: var(--jp-ui-font-color1);
}

.lm-CommandPalette-item {
  padding: 4px 12px 4px 4px;
  color: var(--jp-ui-font-color1);
  font-size: var(--jp-ui-font-size1);
  font-weight: 400;
  display: flex;
}

.lm-CommandPalette-item.lm-mod-disabled {
  color: var(--jp-ui-font-color2);
}

.lm-CommandPalette-item.lm-mod-active {
  color: var(--jp-ui-inverse-font-color1);
  background: var(--jp-brand-color1);
}

.lm-CommandPalette-item.lm-mod-active .lm-CommandPalette-itemLabel > mark {
  color: var(--jp-ui-inverse-font-color0);
}

.lm-CommandPalette-item.lm-mod-active .jp-icon-selectable[fill] {
  fill: var(--jp-layout-color0);
}

.lm-CommandPalette-item.lm-mod-active:hover:not(.lm-mod-disabled) {
  color: var(--jp-ui-inverse-font-color1);
  background: var(--jp-brand-color1);
}

.lm-CommandPalette-item:hover:not(.lm-mod-active):not(.lm-mod-disabled) {
  background: var(--jp-layout-color2);
}

.lm-CommandPalette-itemContent {
  overflow: hidden;
}

.lm-CommandPalette-itemLabel > mark {
  color: var(--jp-ui-font-color0);
  background-color: transparent;
  font-weight: bold;
}

.lm-CommandPalette-item.lm-mod-disabled mark {
  color: var(--jp-ui-font-color2);
}

.lm-CommandPalette-item .lm-CommandPalette-itemIcon {
  margin: 0 4px 0 0;
  position: relative;
  width: 16px;
  top: 2px;
  flex: 0 0 auto;
}

.lm-CommandPalette-item.lm-mod-disabled .lm-CommandPalette-itemIcon {
  opacity: 0.6;
}

.lm-CommandPalette-item .lm-CommandPalette-itemShortcut {
  flex: 0 0 auto;
}

.lm-CommandPalette-itemCaption {
  display: none;
}

.lm-CommandPalette-content {
  background-color: var(--jp-layout-color1);
}

.lm-CommandPalette-content:empty::after {
  content: 'No results';
  margin: auto;
  margin-top: 20px;
  width: 100px;
  display: block;
  font-size: var(--jp-ui-font-size2);
  font-family: var(--jp-ui-font-family);
  font-weight: lighter;
}

.lm-CommandPalette-emptyMessage {
  text-align: center;
  margin-top: 24px;
  line-height: 1.32;
  padding: 0 8px;
  color: var(--jp-content-font-color3);
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2014-2017, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-Dialog {
  position: absolute;
  z-index: 10000;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  top: 0;
  left: 0;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  background: var(--jp-dialog-background);
}

.jp-Dialog-content {
  display: flex;
  flex-direction: column;
  margin-left: auto;
  margin-right: auto;
  background: var(--jp-layout-color1);
  padding: 24px 24px 12px;
  min-width: 300px;
  min-height: 150px;
  max-width: 1000px;
  max-height: 500px;
  box-sizing: border-box;
  box-shadow: var(--jp-elevation-z20);
  word-wrap: break-word;
  border-radius: var(--jp-border-radius);

  /* This is needed so that all font sizing of children done in ems is
   * relative to this base size */
  font-size: var(--jp-ui-font-size1);
  color: var(--jp-ui-font-color1);
  resize: both;
}

.jp-Dialog-content.jp-Dialog-content-small {
  max-width: 500px;
}

.jp-Dialog-button {
  overflow: visible;
}

button.jp-Dialog-button:focus {
  outline: 1px solid var(--jp-brand-color1);
  outline-offset: 4px;
  -moz-outline-radius: 0;
}

button.jp-Dialog-button:focus::-moz-focus-inner {
  border: 0;
}

button.jp-Dialog-button.jp-mod-styled.jp-mod-accept:focus,
button.jp-Dialog-button.jp-mod-styled.jp-mod-warn:focus,
button.jp-Dialog-button.jp-mod-styled.jp-mod-reject:focus {
  outline-offset: 4px;
  -moz-outline-radius: 0;
}

button.jp-Dialog-button.jp-mod-styled.jp-mod-accept:focus {
  outline: 1px solid var(--jp-accept-color-normal, var(--jp-brand-color1));
}

button.jp-Dialog-button.jp-mod-styled.jp-mod-warn:focus {
  outline: 1px solid var(--jp-warn-color-normal, var(--jp-error-color1));
}

button.jp-Dialog-button.jp-mod-styled.jp-mod-reject:focus {
  outline: 1px solid var(--jp-reject-color-normal, var(--md-grey-600));
}

button.jp-Dialog-close-button {
  padding: 0;
  height: 100%;
  min-width: unset;
  min-height: unset;
}

.jp-Dialog-header {
  display: flex;
  justify-content: space-between;
  flex: 0 0 auto;
  padding-bottom: 12px;
  font-size: var(--jp-ui-font-size3);
  font-weight: 400;
  color: var(--jp-ui-font-color1);
}

.jp-Dialog-body {
  display: flex;
  flex-direction: column;
  flex: 1 1 auto;
  font-size: var(--jp-ui-font-size1);
  background: var(--jp-layout-color1);
  color: var(--jp-ui-font-color1);
  overflow: auto;
}

.jp-Dialog-footer {
  display: flex;
  flex-direction: row;
  justify-content: flex-end;
  align-items: center;
  flex: 0 0 auto;
  margin-left: -12px;
  margin-right: -12px;
  padding: 12px;
}

.jp-Dialog-checkbox {
  padding-right: 5px;
}

.jp-Dialog-checkbox > input:focus-visible {
  outline: 1px solid var(--jp-input-active-border-color);
  outline-offset: 1px;
}

.jp-Dialog-spacer {
  flex: 1 1 auto;
}

.jp-Dialog-title {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.jp-Dialog-body > .jp-select-wrapper {
  width: 100%;
}

.jp-Dialog-body > button {
  padding: 0 16px;
}

.jp-Dialog-body > label {
  line-height: 1.4;
  color: var(--jp-ui-font-color0);
}

.jp-Dialog-button.jp-mod-styled:not(:last-child) {
  margin-right: 12px;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

.jp-Input-Boolean-Dialog {
  flex-direction: row-reverse;
  align-items: end;
  width: 100%;
}

.jp-Input-Boolean-Dialog > label {
  flex: 1 1 auto;
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2014-2016, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-MainAreaWidget > :focus {
  outline: none;
}

.jp-MainAreaWidget .jp-MainAreaWidget-error {
  padding: 6px;
}

.jp-MainAreaWidget .jp-MainAreaWidget-error > pre {
  width: auto;
  padding: 10px;
  background: var(--jp-error-color3);
  border: var(--jp-border-width) solid var(--jp-error-color1);
  border-radius: var(--jp-border-radius);
  color: var(--jp-ui-font-color1);
  font-size: var(--jp-ui-font-size1);
  white-space: pre-wrap;
  word-wrap: break-word;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/**
 * google-material-color v1.2.6
 * https://github.com/danlevan/google-material-color
 */
:root {
  --md-red-50: #ffebee;
  --md-red-100: #ffcdd2;
  --md-red-200: #ef9a9a;
  --md-red-300: #e57373;
  --md-red-400: #ef5350;
  --md-red-500: #f44336;
  --md-red-600: #e53935;
  --md-red-700: #d32f2f;
  --md-red-800: #c62828;
  --md-red-900: #b71c1c;
  --md-red-A100: #ff8a80;
  --md-red-A200: #ff5252;
  --md-red-A400: #ff1744;
  --md-red-A700: #d50000;
  --md-pink-50: #fce4ec;
  --md-pink-100: #f8bbd0;
  --md-pink-200: #f48fb1;
  --md-pink-300: #f06292;
  --md-pink-400: #ec407a;
  --md-pink-500: #e91e63;
  --md-pink-600: #d81b60;
  --md-pink-700: #c2185b;
  --md-pink-800: #ad1457;
  --md-pink-900: #880e4f;
  --md-pink-A100: #ff80ab;
  --md-pink-A200: #ff4081;
  --md-pink-A400: #f50057;
  --md-pink-A700: #c51162;
  --md-purple-50: #f3e5f5;
  --md-purple-100: #e1bee7;
  --md-purple-200: #ce93d8;
  --md-purple-300: #ba68c8;
  --md-purple-400: #ab47bc;
  --md-purple-500: #9c27b0;
  --md-purple-600: #8e24aa;
  --md-purple-700: #7b1fa2;
  --md-purple-800: #6a1b9a;
  --md-purple-900: #4a148c;
  --md-purple-A100: #ea80fc;
  --md-purple-A200: #e040fb;
  --md-purple-A400: #d500f9;
  --md-purple-A700: #a0f;
  --md-deep-purple-50: #ede7f6;
  --md-deep-purple-100: #d1c4e9;
  --md-deep-purple-200: #b39ddb;
  --md-deep-purple-300: #9575cd;
  --md-deep-purple-400: #7e57c2;
  --md-deep-purple-500: #673ab7;
  --md-deep-purple-600: #5e35b1;
  --md-deep-purple-700: #512da8;
  --md-deep-purple-800: #4527a0;
  --md-deep-purple-900: #311b92;
  --md-deep-purple-A100: #b388ff;
  --md-deep-purple-A200: #7c4dff;
  --md-deep-purple-A400: #651fff;
  --md-deep-purple-A700: #6200ea;
  --md-indigo-50: #e8eaf6;
  --md-indigo-100: #c5cae9;
  --md-indigo-200: #9fa8da;
  --md-indigo-300: #7986cb;
  --md-indigo-400: #5c6bc0;
  --md-indigo-500: #3f51b5;
  --md-indigo-600: #3949ab;
  --md-indigo-700: #303f9f;
  --md-indigo-800: #283593;
  --md-indigo-900: #1a237e;
  --md-indigo-A100: #8c9eff;
  --md-indigo-A200: #536dfe;
  --md-indigo-A400: #3d5afe;
  --md-indigo-A700: #304ffe;
  --md-blue-50: #e3f2fd;
  --md-blue-100: #bbdefb;
  --md-blue-200: #90caf9;
  --md-blue-300: #64b5f6;
  --md-blue-400: #42a5f5;
  --md-blue-500: #2196f3;
  --md-blue-600: #1e88e5;
  --md-blue-700: #1976d2;
  --md-blue-800: #1565c0;
  --md-blue-900: #0d47a1;
  --md-blue-A100: #82b1ff;
  --md-blue-A200: #448aff;
  --md-blue-A400: #2979ff;
  --md-blue-A700: #2962ff;
  --md-light-blue-50: #e1f5fe;
  --md-light-blue-100: #b3e5fc;
  --md-light-blue-200: #81d4fa;
  --md-light-blue-300: #4fc3f7;
  --md-light-blue-400: #29b6f6;
  --md-light-blue-500: #03a9f4;
  --md-light-blue-600: #039be5;
  --md-light-blue-700: #0288d1;
  --md-light-blue-800: #0277bd;
  --md-light-blue-900: #01579b;
  --md-light-blue-A100: #80d8ff;
  --md-light-blue-A200: #40c4ff;
  --md-light-blue-A400: #00b0ff;
  --md-light-blue-A700: #0091ea;
  --md-cyan-50: #e0f7fa;
  --md-cyan-100: #b2ebf2;
  --md-cyan-200: #80deea;
  --md-cyan-300: #4dd0e1;
  --md-cyan-400: #26c6da;
  --md-cyan-500: #00bcd4;
  --md-cyan-600: #00acc1;
  --md-cyan-700: #0097a7;
  --md-cyan-800: #00838f;
  --md-cyan-900: #006064;
  --md-cyan-A100: #84ffff;
  --md-cyan-A200: #18ffff;
  --md-cyan-A400: #00e5ff;
  --md-cyan-A700: #00b8d4;
  --md-teal-50: #e0f2f1;
  --md-teal-100: #b2dfdb;
  --md-teal-200: #80cbc4;
  --md-teal-300: #4db6ac;
  --md-teal-400: #26a69a;
  --md-teal-500: #009688;
  --md-teal-600: #00897b;
  --md-teal-700: #00796b;
  --md-teal-800: #00695c;
  --md-teal-900: #004d40;
  --md-teal-A100: #a7ffeb;
  --md-teal-A200: #64ffda;
  --md-teal-A400: #1de9b6;
  --md-teal-A700: #00bfa5;
  --md-green-50: #e8f5e9;
  --md-green-100: #c8e6c9;
  --md-green-200: #a5d6a7;
  --md-green-300: #81c784;
  --md-green-400: #66bb6a;
  --md-green-500: #4caf50;
  --md-green-600: #43a047;
  --md-green-700: #388e3c;
  --md-green-800: #2e7d32;
  --md-green-900: #1b5e20;
  --md-green-A100: #b9f6ca;
  --md-green-A200: #69f0ae;
  --md-green-A400: #00e676;
  --md-green-A700: #00c853;
  --md-light-green-50: #f1f8e9;
  --md-light-green-100: #dcedc8;
  --md-light-green-200: #c5e1a5;
  --md-light-green-300: #aed581;
  --md-light-green-400: #9ccc65;
  --md-light-green-500: #8bc34a;
  --md-light-green-600: #7cb342;
  --md-light-green-700: #689f38;
  --md-light-green-800: #558b2f;
  --md-light-green-900: #33691e;
  --md-light-green-A100: #ccff90;
  --md-light-green-A200: #b2ff59;
  --md-light-green-A400: #76ff03;
  --md-light-green-A700: #64dd17;
  --md-lime-50: #f9fbe7;
  --md-lime-100: #f0f4c3;
  --md-lime-200: #e6ee9c;
  --md-lime-300: #dce775;
  --md-lime-400: #d4e157;
  --md-lime-500: #cddc39;
  --md-lime-600: #c0ca33;
  --md-lime-700: #afb42b;
  --md-lime-800: #9e9d24;
  --md-lime-900: #827717;
  --md-lime-A100: #f4ff81;
  --md-lime-A200: #eeff41;
  --md-lime-A400: #c6ff00;
  --md-lime-A700: #aeea00;
  --md-yellow-50: #fffde7;
  --md-yellow-100: #fff9c4;
  --md-yellow-200: #fff59d;
  --md-yellow-300: #fff176;
  --md-yellow-400: #ffee58;
  --md-yellow-500: #ffeb3b;
  --md-yellow-600: #fdd835;
  --md-yellow-700: #fbc02d;
  --md-yellow-800: #f9a825;
  --md-yellow-900: #f57f17;
  --md-yellow-A100: #ffff8d;
  --md-yellow-A200: #ff0;
  --md-yellow-A400: #ffea00;
  --md-yellow-A700: #ffd600;
  --md-amber-50: #fff8e1;
  --md-amber-100: #ffecb3;
  --md-amber-200: #ffe082;
  --md-amber-300: #ffd54f;
  --md-amber-400: #ffca28;
  --md-amber-500: #ffc107;
  --md-amber-600: #ffb300;
  --md-amber-700: #ffa000;
  --md-amber-800: #ff8f00;
  --md-amber-900: #ff6f00;
  --md-amber-A100: #ffe57f;
  --md-amber-A200: #ffd740;
  --md-amber-A400: #ffc400;
  --md-amber-A700: #ffab00;
  --md-orange-50: #fff3e0;
  --md-orange-100: #ffe0b2;
  --md-orange-200: #ffcc80;
  --md-orange-300: #ffb74d;
  --md-orange-400: #ffa726;
  --md-orange-500: #ff9800;
  --md-orange-600: #fb8c00;
  --md-orange-700: #f57c00;
  --md-orange-800: #ef6c00;
  --md-orange-900: #e65100;
  --md-orange-A100: #ffd180;
  --md-orange-A200: #ffab40;
  --md-orange-A400: #ff9100;
  --md-orange-A700: #ff6d00;
  --md-deep-orange-50: #fbe9e7;
  --md-deep-orange-100: #ffccbc;
  --md-deep-orange-200: #ffab91;
  --md-deep-orange-300: #ff8a65;
  --md-deep-orange-400: #ff7043;
  --md-deep-orange-500: #ff5722;
  --md-deep-orange-600: #f4511e;
  --md-deep-orange-700: #e64a19;
  --md-deep-orange-800: #d84315;
  --md-deep-orange-900: #bf360c;
  --md-deep-orange-A100: #ff9e80;
  --md-deep-orange-A200: #ff6e40;
  --md-deep-orange-A400: #ff3d00;
  --md-deep-orange-A700: #dd2c00;
  --md-brown-50: #efebe9;
  --md-brown-100: #d7ccc8;
  --md-brown-200: #bcaaa4;
  --md-brown-300: #a1887f;
  --md-brown-400: #8d6e63;
  --md-brown-500: #795548;
  --md-brown-600: #6d4c41;
  --md-brown-700: #5d4037;
  --md-brown-800: #4e342e;
  --md-brown-900: #3e2723;
  --md-grey-50: #fafafa;
  --md-grey-100: #f5f5f5;
  --md-grey-200: #eee;
  --md-grey-300: #e0e0e0;
  --md-grey-400: #bdbdbd;
  --md-grey-500: #9e9e9e;
  --md-grey-600: #757575;
  --md-grey-700: #616161;
  --md-grey-800: #424242;
  --md-grey-900: #212121;
  --md-blue-grey-50: #eceff1;
  --md-blue-grey-100: #cfd8dc;
  --md-blue-grey-200: #b0bec5;
  --md-blue-grey-300: #90a4ae;
  --md-blue-grey-400: #78909c;
  --md-blue-grey-500: #607d8b;
  --md-blue-grey-600: #546e7a;
  --md-blue-grey-700: #455a64;
  --md-blue-grey-800: #37474f;
  --md-blue-grey-900: #263238;
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2014-2017, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| RenderedText
|----------------------------------------------------------------------------*/

:root {
  /* This is the padding value to fill the gaps between lines containing spans with background color. */
  --jp-private-code-span-padding: calc(
    (var(--jp-code-line-height) - 1) * var(--jp-code-font-size) / 2
  );
}

.jp-RenderedText {
  text-align: left;
  padding-left: var(--jp-code-padding);
  line-height: var(--jp-code-line-height);
  font-family: var(--jp-code-font-family);
}

.jp-RenderedText pre,
.jp-RenderedJavaScript pre,
.jp-RenderedHTMLCommon pre {
  color: var(--jp-content-font-color1);
  font-size: var(--jp-code-font-size);
  border: none;
  margin: 0;
  padding: 0;
}

.jp-RenderedText pre a:link {
  text-decoration: none;
  color: var(--jp-content-link-color);
}

.jp-RenderedText pre a:hover {
  text-decoration: underline;
  color: var(--jp-content-link-color);
}

.jp-RenderedText pre a:visited {
  text-decoration: none;
  color: var(--jp-content-link-color);
}

/* console foregrounds and backgrounds */
.jp-RenderedText pre .ansi-black-fg {
  color: #3e424d;
}

.jp-RenderedText pre .ansi-red-fg {
  color: #e75c58;
}

.jp-RenderedText pre .ansi-green-fg {
  color: #00a250;
}

.jp-RenderedText pre .ansi-yellow-fg {
  color: #ddb62b;
}

.jp-RenderedText pre .ansi-blue-fg {
  color: #208ffb;
}

.jp-RenderedText pre .ansi-magenta-fg {
  color: #d160c4;
}

.jp-RenderedText pre .ansi-cyan-fg {
  color: #60c6c8;
}

.jp-RenderedText pre .ansi-white-fg {
  color: #c5c1b4;
}

.jp-RenderedText pre .ansi-black-bg {
  background-color: #3e424d;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-red-bg {
  background-color: #e75c58;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-green-bg {
  background-color: #00a250;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-yellow-bg {
  background-color: #ddb62b;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-blue-bg {
  background-color: #208ffb;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-magenta-bg {
  background-color: #d160c4;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-cyan-bg {
  background-color: #60c6c8;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-white-bg {
  background-color: #c5c1b4;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-black-intense-fg {
  color: #282c36;
}

.jp-RenderedText pre .ansi-red-intense-fg {
  color: #b22b31;
}

.jp-RenderedText pre .ansi-green-intense-fg {
  color: #007427;
}

.jp-RenderedText pre .ansi-yellow-intense-fg {
  color: #b27d12;
}

.jp-RenderedText pre .ansi-blue-intense-fg {
  color: #0065ca;
}

.jp-RenderedText pre .ansi-magenta-intense-fg {
  color: #a03196;
}

.jp-RenderedText pre .ansi-cyan-intense-fg {
  color: #258f8f;
}

.jp-RenderedText pre .ansi-white-intense-fg {
  color: #a1a6b2;
}

.jp-RenderedText pre .ansi-black-intense-bg {
  background-color: #282c36;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-red-intense-bg {
  background-color: #b22b31;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-green-intense-bg {
  background-color: #007427;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-yellow-intense-bg {
  background-color: #b27d12;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-blue-intense-bg {
  background-color: #0065ca;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-magenta-intense-bg {
  background-color: #a03196;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-cyan-intense-bg {
  background-color: #258f8f;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-white-intense-bg {
  background-color: #a1a6b2;
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-default-inverse-fg {
  color: var(--jp-ui-inverse-font-color0);
}

.jp-RenderedText pre .ansi-default-inverse-bg {
  background-color: var(--jp-inverse-layout-color0);
  padding: var(--jp-private-code-span-padding) 0;
}

.jp-RenderedText pre .ansi-bold {
  font-weight: bold;
}

.jp-RenderedText pre .ansi-underline {
  text-decoration: underline;
}

.jp-RenderedText[data-mime-type='application/vnd.jupyter.stderr'] {
  background: var(--jp-rendermime-error-background);
  padding-top: var(--jp-code-padding);
}

/*-----------------------------------------------------------------------------
| RenderedLatex
|----------------------------------------------------------------------------*/

.jp-RenderedLatex {
  color: var(--jp-content-font-color1);
  font-size: var(--jp-content-font-size1);
  line-height: var(--jp-content-line-height);
}

/* Left-justify outputs.*/
.jp-OutputArea-output.jp-RenderedLatex {
  padding: var(--jp-code-padding);
  text-align: left;
}

/*-----------------------------------------------------------------------------
| RenderedHTML
|----------------------------------------------------------------------------*/

.jp-RenderedHTMLCommon {
  color: var(--jp-content-font-color1);
  font-family: var(--jp-content-font-family);
  font-size: var(--jp-content-font-size1);
  line-height: var(--jp-content-line-height);

  /* Give a bit more R padding on Markdown text to keep line lengths reasonable */
  padding-right: 20px;
}

.jp-RenderedHTMLCommon em {
  font-style: italic;
}

.jp-RenderedHTMLCommon strong {
  font-weight: bold;
}

.jp-RenderedHTMLCommon u {
  text-decoration: underline;
}

.jp-RenderedHTMLCommon a:link {
  text-decoration: none;
  color: var(--jp-content-link-color);
}

.jp-RenderedHTMLCommon a:hover {
  text-decoration: underline;
  color: var(--jp-content-link-color);
}

.jp-RenderedHTMLCommon a:visited {
  text-decoration: none;
  color: var(--jp-content-link-color);
}

/* Headings */

.jp-RenderedHTMLCommon h1,
.jp-RenderedHTMLCommon h2,
.jp-RenderedHTMLCommon h3,
.jp-RenderedHTMLCommon h4,
.jp-RenderedHTMLCommon h5,
.jp-RenderedHTMLCommon h6 {
  line-height: var(--jp-content-heading-line-height);
  font-weight: var(--jp-content-heading-font-weight);
  font-style: normal;
  margin: var(--jp-content-heading-margin-top) 0
    var(--jp-content-heading-margin-bottom) 0;
}

.jp-RenderedHTMLCommon h1:first-child,
.jp-RenderedHTMLCommon h2:first-child,
.jp-RenderedHTMLCommon h3:first-child,
.jp-RenderedHTMLCommon h4:first-child,
.jp-RenderedHTMLCommon h5:first-child,
.jp-RenderedHTMLCommon h6:first-child {
  margin-top: calc(0.5 * var(--jp-content-heading-margin-top));
}

.jp-RenderedHTMLCommon h1:last-child,
.jp-RenderedHTMLCommon h2:last-child,
.jp-RenderedHTMLCommon h3:last-child,
.jp-RenderedHTMLCommon h4:last-child,
.jp-RenderedHTMLCommon h5:last-child,
.jp-RenderedHTMLCommon h6:last-child {
  margin-bottom: calc(0.5 * var(--jp-content-heading-margin-bottom));
}

.jp-RenderedHTMLCommon h1 {
  font-size: var(--jp-content-font-size5);
}

.jp-RenderedHTMLCommon h2 {
  font-size: var(--jp-content-font-size4);
}

.jp-RenderedHTMLCommon h3 {
  font-size: var(--jp-content-font-size3);
}

.jp-RenderedHTMLCommon h4 {
  font-size: var(--jp-content-font-size2);
}

.jp-RenderedHTMLCommon h5 {
  font-size: var(--jp-content-font-size1);
}

.jp-RenderedHTMLCommon h6 {
  font-size: var(--jp-content-font-size0);
}

/* Lists */

/* stylelint-disable selector-max-type, selector-max-compound-selectors */

.jp-RenderedHTMLCommon ul:not(.list-inline),
.jp-RenderedHTMLCommon ol:not(.list-inline) {
  padding-left: 2em;
}

.jp-RenderedHTMLCommon ul {
  list-style: disc;
}

.jp-RenderedHTMLCommon ul ul {
  list-style: square;
}

.jp-RenderedHTMLCommon ul ul ul {
  list-style: circle;
}

.jp-RenderedHTMLCommon ol {
  list-style: decimal;
}

.jp-RenderedHTMLCommon ol ol {
  list-style: upper-alpha;
}

.jp-RenderedHTMLCommon ol ol ol {
  list-style: lower-alpha;
}

.jp-RenderedHTMLCommon ol ol ol ol {
  list-style: lower-roman;
}

.jp-RenderedHTMLCommon ol ol ol ol ol {
  list-style: decimal;
}

.jp-RenderedHTMLCommon ol,
.jp-RenderedHTMLCommon ul {
  margin-bottom: 1em;
}

.jp-RenderedHTMLCommon ul ul,
.jp-RenderedHTMLCommon ul ol,
.jp-RenderedHTMLCommon ol ul,
.jp-RenderedHTMLCommon ol ol {
  margin-bottom: 0;
}

/* stylelint-enable selector-max-type, selector-max-compound-selectors */

.jp-RenderedHTMLCommon hr {
  color: var(--jp-border-color2);
  background-color: var(--jp-border-color1);
  margin-top: 1em;
  margin-bottom: 1em;
}

.jp-RenderedHTMLCommon > pre {
  margin: 1.5em 2em;
}

.jp-RenderedHTMLCommon pre,
.jp-RenderedHTMLCommon code {
  border: 0;
  background-color: var(--jp-layout-color0);
  color: var(--jp-content-font-color1);
  font-family: var(--jp-code-font-family);
  font-size: inherit;
  line-height: var(--jp-code-line-height);
  padding: 0;
  white-space: pre-wrap;
}

.jp-RenderedHTMLCommon :not(pre) > code {
  background-color: var(--jp-layout-color2);
  padding: 1px 5px;
}

/* Tables */

.jp-RenderedHTMLCommon table {
  border-collapse: collapse;
  border-spacing: 0;
  border: none;
  color: var(--jp-ui-font-color1);
  font-size: var(--jp-ui-font-size1);
  table-layout: fixed;
  margin-left: auto;
  margin-bottom: 1em;
  margin-right: auto;
}

.jp-RenderedHTMLCommon thead {
  border-bottom: var(--jp-border-width) solid var(--jp-border-color1);
  vertical-align: bottom;
}

.jp-RenderedHTMLCommon td,
.jp-RenderedHTMLCommon th,
.jp-RenderedHTMLCommon tr {
  vertical-align: middle;
  padding: 0.5em;
  line-height: normal;
  white-space: normal;
  max-width: none;
  border: none;
}

.jp-RenderedMarkdown.jp-RenderedHTMLCommon td,
.jp-RenderedMarkdown.jp-RenderedHTMLCommon th {
  max-width: none;
}

:not(.jp-RenderedMarkdown).jp-RenderedHTMLCommon td,
:not(.jp-RenderedMarkdown).jp-RenderedHTMLCommon th,
:not(.jp-RenderedMarkdown).jp-RenderedHTMLCommon tr {
  text-align: right;
}

.jp-RenderedHTMLCommon th {
  font-weight: bold;
}

.jp-RenderedHTMLCommon tbody tr:nth-child(odd) {
  background: var(--jp-layout-color0);
}

.jp-RenderedHTMLCommon tbody tr:nth-child(even) {
  background: var(--jp-rendermime-table-row-background);
}

.jp-RenderedHTMLCommon tbody tr:hover {
  background: var(--jp-rendermime-table-row-hover-background);
}

.jp-RenderedHTMLCommon p {
  text-align: left;
  margin: 0;
  margin-bottom: 1em;
}

.jp-RenderedHTMLCommon img {
  -moz-force-broken-image-icon: 1;
}

/* Restrict to direct children as other images could be nested in other content. */
.jp-RenderedHTMLCommon > img {
  display: block;
  margin-left: 0;
  margin-right: 0;
  margin-bottom: 1em;
}

/* Change color behind transparent images if they need it... */
[data-jp-theme-light='false'] .jp-RenderedImage img.jp-needs-light-background {
  background-color: var(--jp-inverse-layout-color1);
}

[data-jp-theme-light='true'] .jp-RenderedImage img.jp-needs-dark-background {
  background-color: var(--jp-inverse-layout-color1);
}

.jp-RenderedHTMLCommon img,
.jp-RenderedImage img,
.jp-RenderedHTMLCommon svg,
.jp-RenderedSVG svg {
  max-width: 100%;
  height: auto;
}

.jp-RenderedHTMLCommon img.jp-mod-unconfined,
.jp-RenderedImage img.jp-mod-unconfined,
.jp-RenderedHTMLCommon svg.jp-mod-unconfined,
.jp-RenderedSVG svg.jp-mod-unconfined {
  max-width: none;
}

.jp-RenderedHTMLCommon .alert {
  padding: var(--jp-notebook-padding);
  border: var(--jp-border-width) solid transparent;
  border-radius: var(--jp-border-radius);
  margin-bottom: 1em;
}

.jp-RenderedHTMLCommon .alert-info {
  color: var(--jp-info-color0);
  background-color: var(--jp-info-color3);
  border-color: var(--jp-info-color2);
}

.jp-RenderedHTMLCommon .alert-info hr {
  border-color: var(--jp-info-color3);
}

.jp-RenderedHTMLCommon .alert-info > p:last-child,
.jp-RenderedHTMLCommon .alert-info > ul:last-child {
  margin-bottom: 0;
}

.jp-RenderedHTMLCommon .alert-warning {
  color: var(--jp-warn-color0);
  background-color: var(--jp-warn-color3);
  border-color: var(--jp-warn-color2);
}

.jp-RenderedHTMLCommon .alert-warning hr {
  border-color: var(--jp-warn-color3);
}

.jp-RenderedHTMLCommon .alert-warning > p:last-child,
.jp-RenderedHTMLCommon .alert-warning > ul:last-child {
  margin-bottom: 0;
}

.jp-RenderedHTMLCommon .alert-success {
  color: var(--jp-success-color0);
  background-color: var(--jp-success-color3);
  border-color: var(--jp-success-color2);
}

.jp-RenderedHTMLCommon .alert-success hr {
  border-color: var(--jp-success-color3);
}

.jp-RenderedHTMLCommon .alert-success > p:last-child,
.jp-RenderedHTMLCommon .alert-success > ul:last-child {
  margin-bottom: 0;
}

.jp-RenderedHTMLCommon .alert-danger {
  color: var(--jp-error-color0);
  background-color: var(--jp-error-color3);
  border-color: var(--jp-error-color2);
}

.jp-RenderedHTMLCommon .alert-danger hr {
  border-color: var(--jp-error-color3);
}

.jp-RenderedHTMLCommon .alert-danger > p:last-child,
.jp-RenderedHTMLCommon .alert-danger > ul:last-child {
  margin-bottom: 0;
}

.jp-RenderedHTMLCommon blockquote {
  margin: 1em 2em;
  padding: 0 1em;
  border-left: 5px solid var(--jp-border-color2);
}

a.jp-InternalAnchorLink {
  visibility: hidden;
  margin-left: 8px;
  color: var(--md-blue-800);
}

h1:hover .jp-InternalAnchorLink,
h2:hover .jp-InternalAnchorLink,
h3:hover .jp-InternalAnchorLink,
h4:hover .jp-InternalAnchorLink,
h5:hover .jp-InternalAnchorLink,
h6:hover .jp-InternalAnchorLink {
  visibility: visible;
}

.jp-RenderedHTMLCommon kbd {
  background-color: var(--jp-rendermime-table-row-background);
  border: 1px solid var(--jp-border-color0);
  border-bottom-color: var(--jp-border-color2);
  border-radius: 3px;
  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.25);
  display: inline-block;
  font-size: var(--jp-ui-font-size0);
  line-height: 1em;
  padding: 0.2em 0.5em;
}

/* Most direct children of .jp-RenderedHTMLCommon have a margin-bottom of 1.0.
 * At the bottom of cells this is a bit too much as there is also spacing
 * between cells. Going all the way to 0 gets too tight between markdown and
 * code cells.
 */
.jp-RenderedHTMLCommon > *:last-child {
  margin-bottom: 0.5em;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Copyright (c) 2014-2017, PhosphorJS Contributors
|
| Distributed under the terms of the BSD 3-Clause License.
|
| The full license is in the file LICENSE, distributed with this software.
|----------------------------------------------------------------------------*/

.lm-cursor-backdrop {
  position: fixed;
  width: 200px;
  height: 200px;
  margin-top: -100px;
  margin-left: -100px;
  will-change: transform;
  z-index: 100;
}

.lm-mod-drag-image {
  will-change: transform;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

.jp-lineFormSearch {
  padding: 4px 12px;
  background-color: var(--jp-layout-color2);
  box-shadow: var(--jp-toolbar-box-shadow);
  z-index: 2;
  font-size: var(--jp-ui-font-size1);
}

.jp-lineFormCaption {
  font-size: var(--jp-ui-font-size0);
  line-height: var(--jp-ui-font-size1);
  margin-top: 4px;
  color: var(--jp-ui-font-color0);
}

.jp-baseLineForm {
  border: none;
  border-radius: 0;
  position: absolute;
  background-size: 16px;
  background-repeat: no-repeat;
  background-position: center;
  outline: none;
}

.jp-lineFormButtonContainer {
  top: 4px;
  right: 8px;
  height: 24px;
  padding: 0 12px;
  width: 12px;
}

.jp-lineFormButtonIcon {
  top: 0;
  right: 0;
  background-color: var(--jp-brand-color1);
  height: 100%;
  width: 100%;
  box-sizing: border-box;
  padding: 4px 6px;
}

.jp-lineFormButton {
  top: 0;
  right: 0;
  background-color: transparent;
  height: 100%;
  width: 100%;
  box-sizing: border-box;
}

.jp-lineFormWrapper {
  overflow: hidden;
  padding: 0 8px;
  border: 1px solid var(--jp-border-color0);
  background-color: var(--jp-input-active-background);
  height: 22px;
}

.jp-lineFormWrapperFocusWithin {
  border: var(--jp-border-width) solid var(--md-blue-500);
  box-shadow: inset 0 0 4px var(--md-blue-300);
}

.jp-lineFormInput {
  background: transparent;
  width: 200px;
  height: 100%;
  border: none;
  outline: none;
  color: var(--jp-ui-font-color0);
  line-height: 28px;
}

/*-----------------------------------------------------------------------------
| Copyright (c) 2014-2016, Jupyter Development Team.
|
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-JSONEditor {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.jp-JSONEditor-host {
  flex: 1 1 auto;
  border: var(--jp-border-width) solid var(--jp-input-border-color);
  border-radius: 0;
  background: var(--jp-layout-color0);
  min-height: 50px;
  padding: 1px;
}

.jp-JSONEditor.jp-mod-error .jp-JSONEditor-host {
  border-color: red;
  outline-color: red;
}

.jp-JSONEditor-header {
  display: flex;
  flex: 1 0 auto;
  padding: 0 0 0 12px;
}

.jp-JSONEditor-header label {
  flex: 0 0 auto;
}

.jp-JSONEditor-commitButton {
  height: 16px;
  width: 16px;
  background-size: 18px;
  background-repeat: no-repeat;
  background-position: center;
}

.jp-JSONEditor-host.jp-mod-focused {
  background-color: var(--jp-input-active-background);
  border: 1px solid var(--jp-input-active-border-color);
  box-shadow: var(--jp-input-box-shadow);
}

.jp-Editor.jp-mod-dropTarget {
  border: var(--jp-border-width) solid var(--jp-input-active-border-color);
  box-shadow: var(--jp-input-box-shadow);
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/
.jp-DocumentSearch-input {
  border: none;
  outline: none;
  color: var(--jp-ui-font-color0);
  font-size: var(--jp-ui-font-size1);
  background-color: var(--jp-layout-color0);
  font-family: var(--jp-ui-font-family);
  padding: 2px 1px;
  resize: none;
}

.jp-DocumentSearch-overlay {
  position: absolute;
  background-color: var(--jp-toolbar-background);
  border-bottom: var(--jp-border-width) solid var(--jp-toolbar-border-color);
  border-left: var(--jp-border-width) solid var(--jp-toolbar-border-color);
  top: 0;
  right: 0;
  z-index: 7;
  min-width: 405px;
  padding: 2px;
  font-size: var(--jp-ui-font-size1);

  --jp-private-document-search-button-height: 20px;
}

.jp-DocumentSearch-overlay button {
  background-color: var(--jp-toolbar-background);
  outline: 0;
}

.jp-DocumentSearch-overlay button:hover {
  background-color: var(--jp-layout-color2);
}

.jp-DocumentSearch-overlay button:active {
  background-color: var(--jp-layout-color3);
}

.jp-DocumentSearch-overlay-row {
  display: flex;
  align-items: center;
  margin-bottom: 2px;
}

.jp-DocumentSearch-button-content {
  display: inline-block;
  cursor: pointer;
  box-sizing: border-box;
  width: 100%;
  height: 100%;
}

.jp-DocumentSearch-button-content svg {
  width: 100%;
  height: 100%;
}

.jp-DocumentSearch-input-wrapper {
  border: var(--jp-border-width) solid var(--jp-border-color0);
  display: flex;
  background-color: var(--jp-layout-color0);
  margin: 2px;
}

.jp-DocumentSearch-input-wrapper:focus-within {
  border-color: var(--jp-cell-editor-active-border-color);
}

.jp-DocumentSearch-toggle-wrapper,
.jp-DocumentSearch-button-wrapper {
  all: initial;
  overflow: hidden;
  display: inline-block;
  border: none;
  box-sizing: border-box;
}

.jp-DocumentSearch-toggle-wrapper {
  width: 14px;
  height: 14px;
}

.jp-DocumentSearch-button-wrapper {
  width: var(--jp-private-document-search-button-height);
  height: var(--jp-private-document-search-button-height);
}

.jp-DocumentSearch-toggle-wrapper:focus,
.jp-DocumentSearch-button-wrapper:focus {
  outline: var(--jp-border-width) solid
    var(--jp-cell-editor-active-border-color);
  outline-offset: -1px;
}

.jp-DocumentSearch-toggle-wrapper,
.jp-DocumentSearch-button-wrapper,
.jp-DocumentSearch-button-content:focus {
  outline: none;
}

.jp-DocumentSearch-toggle-placeholder {
  width: 5px;
}

.jp-DocumentSearch-input-button::before {
  display: block;
  padding-top: 100%;
}

.jp-DocumentSearch-input-button-off {
  opacity: var(--jp-search-toggle-off-opacity);
}

.jp-DocumentSearch-input-button-off:hover {
  opacity: var(--jp-search-toggle-hover-opacity);
}

.jp-DocumentSearch-input-button-on {
  opacity: var(--jp-search-toggle-on-opacity);
}

.jp-DocumentSearch-index-counter {
  padding-left: 10px;
  padding-right: 10px;
  user-select: none;
  min-width: 35px;
  display: inline-block;
}

.jp-DocumentSearch-up-down-wrapper {
  display: inline-block;
  padding-right: 2px;
  margin-left: auto;
  white-space: nowrap;
}

.jp-DocumentSearch-spacer {
  margin-left: auto;
}

.jp-DocumentSearch-up-down-wrapper button {
  outline: 0;
  border: none;
  width: var(--jp-private-document-search-button-height);
  height: var(--jp-private-document-search-button-height);
  vertical-align: middle;
  margin: 1px 5px 2px;
}

.jp-DocumentSearch-up-down-button:hover {
  background-color: var(--jp-layout-color2);
}

.jp-DocumentSearch-up-down-button:active {
  background-color: var(--jp-layout-color3);
}

.jp-DocumentSearch-filter-button {
  border-radius: var(--jp-border-radius);
}

.jp-DocumentSearch-filter-button:hover {
  background-color: var(--jp-layout-color2);
}

.jp-DocumentSearch-filter-button-enabled {
  background-color: var(--jp-layout-color2);
}

.jp-DocumentSearch-filter-button-enabled:hover {
  background-color: var(--jp-layout-color3);
}

.jp-DocumentSearch-search-options {
  padding: 0 8px;
  margin-left: 3px;
  width: 100%;
  display: grid;
  justify-content: start;
  grid-template-columns: 1fr 1fr;
  align-items: center;
  justify-items: stretch;
}

.jp-DocumentSearch-search-filter-disabled {
  color: var(--jp-ui-font-color2);
}

.jp-DocumentSearch-search-filter {
  display: flex;
  align-items: center;
  user-select: none;
}

.jp-DocumentSearch-regex-error {
  color: var(--jp-error-color0);
}

.jp-DocumentSearch-replace-button-wrapper {
  overflow: hidden;
  display: inline-block;
  box-sizing: border-box;
  border: var(--jp-border-width) solid var(--jp-border-color0);
  margin: auto 2px;
  padding: 1px 4px;
  height: calc(var(--jp-private-document-search-button-height) + 2px);
}

.jp-DocumentSearch-replace-button-wrapper:focus {
  border: var(--jp-border-width) solid var(--jp-cell-editor-active-border-color);
}

.jp-DocumentSearch-replace-button {
  display: inline-block;
  text-align: center;
  cursor: pointer;
  box-sizing: border-box;
  color: var(--jp-ui-font-color1);

  /* height - 2 * (padding of wrapper) */
  line-height: calc(var(--jp-private-document-search-button-height) - 2px);
  width: 100%;
  height: 100%;
}

.jp-DocumentSearch-replace-button:focus {
  outline: none;
}

.jp-DocumentSearch-replace-wrapper-class {
  margin-left: 14px;
  display: flex;
}

.jp-DocumentSearch-replace-toggle {
  border: none;
  background-color: var(--jp-toolbar-background);
  border-radius: var(--jp-border-radius);
}

.jp-DocumentSearch-replace-toggle:hover {
  background-color: var(--jp-layout-color2);
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.cm-editor {
  line-height: var(--jp-code-line-height);
  font-size: var(--jp-code-font-size);
  font-family: var(--jp-code-font-family);
  border: 0;
  border-radius: 0;
  height: auto;

  /* Changed to auto to autogrow */
}

.cm-editor pre {
  padding: 0 var(--jp-code-padding);
}

.jp-CodeMirrorEditor[data-type='inline'] .cm-dialog {
  background-color: var(--jp-layout-color0);
  color: var(--jp-content-font-color1);
}

.jp-CodeMirrorEditor {
  cursor: text;
}

/* When zoomed out 67% and 33% on a screen of 1440 width x 900 height */
@media screen and (min-width: 2138px) and (max-width: 4319px) {
  .jp-CodeMirrorEditor[data-type='inline'] .cm-cursor {
    border-left: var(--jp-code-cursor-width1) solid
      var(--jp-editor-cursor-color);
  }
}

/* When zoomed out less than 33% */
@media screen and (min-width: 4320px) {
  .jp-CodeMirrorEditor[data-type='inline'] .cm-cursor {
    border-left: var(--jp-code-cursor-width2) solid
      var(--jp-editor-cursor-color);
  }
}

.cm-editor.jp-mod-readOnly .cm-cursor {
  display: none;
}

.jp-CollaboratorCursor {
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: none;
  border-bottom: 3px solid;
  background-clip: content-box;
  margin-left: -5px;
  margin-right: -5px;
}

.cm-searching,
.cm-searching span {
  /* `.cm-searching span`: we need to override syntax highlighting */
  background-color: var(--jp-search-unselected-match-background-color);
  color: var(--jp-search-unselected-match-color);
}

.cm-searching::selection,
.cm-searching span::selection {
  background-color: var(--jp-search-unselected-match-background-color);
  color: var(--jp-search-unselected-match-color);
}

.jp-current-match > .cm-searching,
.jp-current-match > .cm-searching span,
.cm-searching > .jp-current-match,
.cm-searching > .jp-current-match span {
  background-color: var(--jp-search-selected-match-background-color);
  color: var(--jp-search-selected-match-color);
}

.jp-current-match > .cm-searching::selection,
.cm-searching > .jp-current-match::selection,
.jp-current-match > .cm-searching span::selection {
  background-color: var(--jp-search-selected-match-background-color);
  color: var(--jp-search-selected-match-color);
}

.cm-trailingspace {
  background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAFCAYAAAB4ka1VAAAAsElEQVQIHQGlAFr/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA7+r3zKmT0/+pk9P/7+r3zAAAAAAAAAAABAAAAAAAAAAA6OPzM+/q9wAAAAAA6OPzMwAAAAAAAAAAAgAAAAAAAAAAGR8NiRQaCgAZIA0AGR8NiQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQyoYJ/SY80UAAAAASUVORK5CYII=);
  background-position: center left;
  background-repeat: repeat-x;
}

.jp-CollaboratorCursor-hover {
  position: absolute;
  z-index: 1;
  transform: translateX(-50%);
  color: white;
  border-radius: 3px;
  padding-left: 4px;
  padding-right: 4px;
  padding-top: 1px;
  padding-bottom: 1px;
  text-align: center;
  font-size: var(--jp-ui-font-size1);
  white-space: nowrap;
}

.jp-CodeMirror-ruler {
  border-left: 1px dashed var(--jp-border-color2);
}

/* Styles for shared cursors (remote cursor locations and selected ranges) */
.jp-CodeMirrorEditor .cm-ySelectionCaret {
  position: relative;
  border-left: 1px solid black;
  margin-left: -1px;
  margin-right: -1px;
  box-sizing: border-box;
}

.jp-CodeMirrorEditor .cm-ySelectionCaret > .cm-ySelectionInfo {
  white-space: nowrap;
  position: absolute;
  top: -1.15em;
  padding-bottom: 0.05em;
  left: -1px;
  font-size: 0.95em;
  font-family: var(--jp-ui-font-family);
  font-weight: bold;
  line-height: normal;
  user-select: none;
  color: white;
  padding-left: 2px;
  padding-right: 2px;
  z-index: 101;
  transition: opacity 0.3s ease-in-out;
}

.jp-CodeMirrorEditor .cm-ySelectionInfo {
  transition-delay: 0.7s;
  opacity: 0;
}

.jp-CodeMirrorEditor .cm-ySelectionCaret:hover > .cm-ySelectionInfo {
  opacity: 1;
  transition-delay: 0s;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-MimeDocument {
  outline: none;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Variables
|----------------------------------------------------------------------------*/

:root {
  --jp-private-filebrowser-button-height: 28px;
  --jp-private-filebrowser-button-width: 48px;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-FileBrowser .jp-SidePanel-content {
  display: flex;
  flex-direction: column;
}

.jp-FileBrowser-toolbar.jp-Toolbar {
  flex-wrap: wrap;
  row-gap: 12px;
  border-bottom: none;
  height: auto;
  margin: 8px 12px 0;
  box-shadow: none;
  padding: 0;
  justify-content: flex-start;
}

.jp-FileBrowser-Panel {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
}

.jp-BreadCrumbs {
  flex: 0 0 auto;
  margin: 8px 12px;
}

.jp-BreadCrumbs-item {
  margin: 0 2px;
  padding: 0 2px;
  border-radius: var(--jp-border-radius);
  cursor: pointer;
}

.jp-BreadCrumbs-item:hover {
  background-color: var(--jp-layout-color2);
}

.jp-BreadCrumbs-item:first-child {
  margin-left: 0;
}

.jp-BreadCrumbs-item.jp-mod-dropTarget {
  background-color: var(--jp-brand-color2);
  opacity: 0.7;
}

/*-----------------------------------------------------------------------------
| Buttons
|----------------------------------------------------------------------------*/

.jp-FileBrowser-toolbar > .jp-Toolbar-item {
  flex: 0 0 auto;
  padding-left: 0;
  padding-right: 2px;
  align-items: center;
  height: unset;
}

.jp-FileBrowser-toolbar > .jp-Toolbar-item .jp-ToolbarButtonComponent {
  width: 40px;
}

/*-----------------------------------------------------------------------------
| Other styles
|----------------------------------------------------------------------------*/

.jp-FileDialog.jp-mod-conflict input {
  color: var(--jp-error-color1);
}

.jp-FileDialog .jp-new-name-title {
  margin-top: 12px;
}

.jp-LastModified-hidden {
  display: none;
}

.jp-FileSize-hidden {
  display: none;
}

.jp-FileBrowser .lm-AccordionPanel > h3:first-child {
  display: none;
}

/*-----------------------------------------------------------------------------
| DirListing
|----------------------------------------------------------------------------*/

.jp-DirListing {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  outline: 0;
}

.jp-DirListing-header {
  flex: 0 0 auto;
  display: flex;
  flex-direction: row;
  align-items: center;
  overflow: hidden;
  border-top: var(--jp-border-width) solid var(--jp-border-color2);
  border-bottom: var(--jp-border-width) solid var(--jp-border-color1);
  box-shadow: var(--jp-toolbar-box-shadow);
  z-index: 2;
}

.jp-DirListing-headerItem {
  padding: 4px 12px 2px;
  font-weight: 500;
}

.jp-DirListing-headerItem:hover {
  background: var(--jp-layout-color2);
}

.jp-DirListing-headerItem.jp-id-name {
  flex: 1 0 84px;
}

.jp-DirListing-headerItem.jp-id-modified {
  flex: 0 0 112px;
  border-left: var(--jp-border-width) solid var(--jp-border-color2);
  text-align: right;
}

.jp-DirListing-headerItem.jp-id-filesize {
  flex: 0 0 75px;
  border-left: var(--jp-border-width) solid var(--jp-border-color2);
  text-align: right;
}

.jp-id-narrow {
  display: none;
  flex: 0 0 5px;
  padding: 4px;
  border-left: var(--jp-border-width) solid var(--jp-border-color2);
  text-align: right;
  color: var(--jp-border-color2);
}

.jp-DirListing-narrow .jp-id-narrow {
  display: block;
}

.jp-DirListing-narrow .jp-id-modified,
.jp-DirListing-narrow .jp-DirListing-itemModified {
  display: none;
}

.jp-DirListing-headerItem.jp-mod-selected {
  font-weight: 600;
}

/* increase specificity to override bundled default */
.jp-DirListing-content {
  flex: 1 1 auto;
  margin: 0;
  padding: 0;
  list-style-type: none;
  overflow: auto;
  background-color: var(--jp-layout-color1);
}

.jp-DirListing-content mark {
  color: var(--jp-ui-font-color0);
  background-color: transparent;
  font-weight: bold;
}

.jp-DirListing-content .jp-DirListing-item.jp-mod-selected mark {
  color: var(--jp-ui-inverse-font-color0);
}

/* Style the directory listing content when a user drops a file to upload */
.jp-DirListing.jp-mod-native-drop .jp-DirListing-content {
  outline: 5px dashed rgba(128, 128, 128, 0.5);
  outline-offset: -10px;
  cursor: copy;
}

.jp-DirListing-item {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 4px 12px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.jp-DirListing-checkboxWrapper {
  /* Increases hit area of checkbox. */
  padding: 4px;
}

.jp-DirListing-header
  .jp-DirListing-checkboxWrapper
  + .jp-DirListing-headerItem {
  padding-left: 4px;
}

.jp-DirListing-content .jp-DirListing-checkboxWrapper {
  position: relative;
  left: -4px;
  margin: -4px 0 -4px -8px;
}

.jp-DirListing-checkboxWrapper.jp-mod-visible {
  visibility: visible;
}

/* For devices that support hovering, hide checkboxes until hovered, selected...
*/
@media (hover: hover) {
  .jp-DirListing-checkboxWrapper {
    visibility: hidden;
  }

  .jp-DirListing-item:hover .jp-DirListing-checkboxWrapper,
  .jp-DirListing-item.jp-mod-selected .jp-DirListing-checkboxWrapper {
    visibility: visible;
  }
}

.jp-DirListing-item[data-is-dot] {
  opacity: 75%;
}

.jp-DirListing-item.jp-mod-selected {
  color: var(--jp-ui-inverse-font-color1);
  background: var(--jp-brand-color1);
}

.jp-DirListing-item.jp-mod-dropTarget {
  background: var(--jp-brand-color3);
}

.jp-DirListing-item:hover:not(.jp-mod-selected) {
  background: var(--jp-layout-color2);
}

.jp-DirListing-itemIcon {
  flex: 0 0 20px;
  margin-right: 4px;
}

.jp-DirListing-itemText {
  flex: 1 0 64px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  user-select: none;
}

.jp-DirListing-itemText:focus {
  outline-width: 2px;
  outline-color: var(--jp-inverse-layout-color1);
  outline-style: solid;
  outline-offset: 1px;
}

.jp-DirListing-item.jp-mod-selected .jp-DirListing-itemText:focus {
  outline-color: var(--jp-layout-color1);
}

.jp-DirListing-itemModified {
  flex: 0 0 125px;
  text-align: right;
}

.jp-DirListing-itemFileSize {
  flex: 0 0 90px;
  text-align: right;
}

.jp-DirListing-editor {
  flex: 1 0 64px;
  outline: none;
  border: none;
  color: var(--jp-ui-font-color1);
  background-color: var(--jp-layout-color1);
}

.jp-DirListing-item.jp-mod-running .jp-DirListing-itemIcon::before {
  color: var(--jp-success-color1);
  content: '\25CF';
  font-size: 8px;
  position: absolute;
  left: -8px;
}

.jp-DirListing-item.jp-mod-running.jp-mod-selected
  .jp-DirListing-itemIcon::before {
  color: var(--jp-ui-inverse-font-color1);
}

.jp-DirListing-item.lm-mod-drag-image,
.jp-DirListing-item.jp-mod-selected.lm-mod-drag-image {
  font-size: var(--jp-ui-font-size1);
  padding-left: 4px;
  margin-left: 4px;
  width: 160px;
  background-color: var(--jp-ui-inverse-font-color2);
  box-shadow: var(--jp-elevation-z2);
  border-radius: 0;
  color: var(--jp-ui-font-color1);
  transform: translateX(-40%) translateY(-58%);
}

.jp-Document {
  min-width: 120px;
  min-height: 120px;
  outline: none;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Main OutputArea
| OutputArea has a list of Outputs
|----------------------------------------------------------------------------*/

.jp-OutputArea {
  overflow-y: auto;
}

.jp-OutputArea-child {
  display: table;
  table-layout: fixed;
  width: 100%;
  overflow: hidden;
}

.jp-OutputPrompt {
  width: var(--jp-cell-prompt-width);
  color: var(--jp-cell-outprompt-font-color);
  font-family: var(--jp-cell-prompt-font-family);
  padding: var(--jp-code-padding);
  letter-spacing: var(--jp-cell-prompt-letter-spacing);
  line-height: var(--jp-code-line-height);
  font-size: var(--jp-code-font-size);
  border: var(--jp-border-width) solid transparent;
  opacity: var(--jp-cell-prompt-opacity);

  /* Right align prompt text, don't wrap to handle large prompt numbers */
  text-align: right;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;

  /* Disable text selection */
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.jp-OutputArea-prompt {
  display: table-cell;
  vertical-align: top;
}

.jp-OutputArea-output {
  display: table-cell;
  width: 100%;
  height: auto;
  overflow: auto;
  user-select: text;
  -moz-user-select: text;
  -webkit-user-select: text;
  -ms-user-select: text;
}

.jp-OutputArea .jp-RenderedText {
  padding-left: 1ch;
}

/**
 * Prompt overlay.
 */

.jp-OutputArea-promptOverlay {
  position: absolute;
  top: 0;
  width: var(--jp-cell-prompt-width);
  height: 100%;
  opacity: 0.5;
}

.jp-OutputArea-promptOverlay:hover {
  background: var(--jp-layout-color2);
  box-shadow: inset 0 0 1px var(--jp-inverse-layout-color0);
  cursor: zoom-out;
}

.jp-mod-outputsScrolled .jp-OutputArea-promptOverlay:hover {
  cursor: zoom-in;
}

/**
 * Isolated output.
 */
.jp-OutputArea-output.jp-mod-isolated {
  width: 100%;
  display: block;
}

/*
When drag events occur, `lm-mod-override-cursor` is added to the body.
Because iframes steal all cursor events, the following two rules are necessary
to suppress pointer events while resize drags are occurring. There may be a
better solution to this problem.
*/
body.lm-mod-override-cursor .jp-OutputArea-output.jp-mod-isolated {
  position: relative;
}

body.lm-mod-override-cursor .jp-OutputArea-output.jp-mod-isolated::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: transparent;
}

/* pre */

.jp-OutputArea-output pre {
  border: none;
  margin: 0;
  padding: 0;
  overflow-x: auto;
  overflow-y: auto;
  word-break: break-all;
  word-wrap: break-word;
  white-space: pre-wrap;
}

/* tables */

.jp-OutputArea-output.jp-RenderedHTMLCommon table {
  margin-left: 0;
  margin-right: 0;
}

/* description lists */

.jp-OutputArea-output dl,
.jp-OutputArea-output dt,
.jp-OutputArea-output dd {
  display: block;
}

.jp-OutputArea-output dl {
  width: 100%;
  overflow: hidden;
  padding: 0;
  margin: 0;
}

.jp-OutputArea-output dt {
  font-weight: bold;
  float: left;
  width: 20%;
  padding: 0;
  margin: 0;
}

.jp-OutputArea-output dd {
  float: left;
  width: 80%;
  padding: 0;
  margin: 0;
}

.jp-TrimmedOutputs pre {
  background: var(--jp-layout-color3);
  font-size: calc(var(--jp-code-font-size) * 1.4);
  text-align: center;
  text-transform: uppercase;
}

/* Hide the gutter in case of
 *  - nested output areas (e.g. in the case of output widgets)
 *  - mirrored output areas
 */
.jp-OutputArea .jp-OutputArea .jp-OutputArea-prompt {
  display: none;
}

/* Hide empty lines in the output area, for instance due to cleared widgets */
.jp-OutputArea-prompt:empty {
  padding: 0;
  border: 0;
}

/*-----------------------------------------------------------------------------
| executeResult is added to any Output-result for the display of the object
| returned by a cell
|----------------------------------------------------------------------------*/

.jp-OutputArea-output.jp-OutputArea-executeResult {
  margin-left: 0;
  width: 100%;
}

/* Text output with the Out[] prompt needs a top padding to match the
 * alignment of the Out[] prompt itself.
 */
.jp-OutputArea-executeResult .jp-RenderedText.jp-OutputArea-output {
  padding-top: var(--jp-code-padding);
  border-top: var(--jp-border-width) solid transparent;
}

/*-----------------------------------------------------------------------------
| The Stdin output
|----------------------------------------------------------------------------*/

.jp-Stdin-prompt {
  color: var(--jp-content-font-color0);
  padding-right: var(--jp-code-padding);
  vertical-align: baseline;
  flex: 0 0 auto;
}

.jp-Stdin-input {
  font-family: var(--jp-code-font-family);
  font-size: inherit;
  color: inherit;
  background-color: inherit;
  width: 42%;
  min-width: 200px;

  /* make sure input baseline aligns with prompt */
  vertical-align: baseline;

  /* padding + margin = 0.5em between prompt and cursor */
  padding: 0 0.25em;
  margin: 0 0.25em;
  flex: 0 0 70%;
}

.jp-Stdin-input::placeholder {
  opacity: 0;
}

.jp-Stdin-input:focus {
  box-shadow: none;
}

.jp-Stdin-input:focus::placeholder {
  opacity: 1;
}

/*-----------------------------------------------------------------------------
| Output Area View
|----------------------------------------------------------------------------*/

.jp-LinkedOutputView .jp-OutputArea {
  height: 100%;
  display: block;
}

.jp-LinkedOutputView .jp-OutputArea-output:only-child {
  height: 100%;
}

/*-----------------------------------------------------------------------------
| Printing
|----------------------------------------------------------------------------*/

@media print {
  .jp-OutputArea-child {
    break-inside: avoid-page;
  }
}

/*-----------------------------------------------------------------------------
| Mobile
|----------------------------------------------------------------------------*/
@media only screen and (max-width: 760px) {
  .jp-OutputPrompt {
    display: table-row;
    text-align: left;
  }

  .jp-OutputArea-child .jp-OutputArea-output {
    display: table-row;
    margin-left: var(--jp-notebook-padding);
  }
}

/* Trimmed outputs warning */
.jp-TrimmedOutputs > a {
  margin: 10px;
  text-decoration: none;
  cursor: pointer;
}

.jp-TrimmedOutputs > a:hover {
  text-decoration: none;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Table of Contents
|----------------------------------------------------------------------------*/

:root {
  --jp-private-toc-active-width: 4px;
}

.jp-TableOfContents {
  display: flex;
  flex-direction: column;
  background: var(--jp-layout-color1);
  color: var(--jp-ui-font-color1);
  font-size: var(--jp-ui-font-size1);
  height: 100%;
}

.jp-TableOfContents-placeholder {
  text-align: center;
}

.jp-TableOfContents-placeholderContent {
  color: var(--jp-content-font-color2);
  padding: 8px;
}

.jp-TableOfContents-placeholderContent > h3 {
  margin-bottom: var(--jp-content-heading-margin-bottom);
}

.jp-TableOfContents .jp-SidePanel-content {
  overflow-y: auto;
}

.jp-TableOfContents-tree {
  margin: 4px;
}

.jp-TableOfContents ol {
  list-style-type: none;
}

/* stylelint-disable-next-line selector-max-type */
.jp-TableOfContents li > ol {
  /* Align left border with triangle icon center */
  padding-left: 11px;
}

.jp-TableOfContents-content {
  /* left margin for the active heading indicator */
  margin: 0 0 0 var(--jp-private-toc-active-width);
  padding: 0;
  background-color: var(--jp-layout-color1);
}

.jp-tocItem {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.jp-tocItem-heading {
  display: flex;
  cursor: pointer;
}

.jp-tocItem-heading:hover {
  background-color: var(--jp-layout-color2);
}

.jp-tocItem-content {
  display: block;
  padding: 4px 0;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow-x: hidden;
}

.jp-tocItem-collapser {
  height: 20px;
  margin: 2px 2px 0;
  padding: 0;
  background: none;
  border: none;
  cursor: pointer;
}

.jp-tocItem-collapser:hover {
  background-color: var(--jp-layout-color3);
}

/* Active heading indicator */

.jp-tocItem-heading::before {
  content: ' ';
  background: transparent;
  width: var(--jp-private-toc-active-width);
  height: 24px;
  position: absolute;
  left: 0;
  border-radius: var(--jp-border-radius);
}

.jp-tocItem-heading.jp-tocItem-active::before {
  background-color: var(--jp-brand-color1);
}

.jp-tocItem-heading:hover.jp-tocItem-active::before {
  background: var(--jp-brand-color0);
  opacity: 1;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

.jp-Collapser {
  flex: 0 0 var(--jp-cell-collapser-width);
  padding: 0;
  margin: 0;
  border: none;
  outline: none;
  background: transparent;
  border-radius: var(--jp-border-radius);
  opacity: 1;
}

.jp-Collapser-child {
  display: block;
  width: 100%;
  box-sizing: border-box;

  /* height: 100% doesn't work because the height of its parent is computed from content */
  position: absolute;
  top: 0;
  bottom: 0;
}

/*-----------------------------------------------------------------------------
| Printing
|----------------------------------------------------------------------------*/

/*
Hiding collapsers in print mode.

Note: input and output wrappers have "display: block" propery in print mode.
*/

@media print {
  .jp-Collapser {
    display: none;
  }
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Header/Footer
|----------------------------------------------------------------------------*/

/* Hidden by zero height by default */
.jp-CellHeader,
.jp-CellFooter {
  height: 0;
  width: 100%;
  padding: 0;
  margin: 0;
  border: none;
  outline: none;
  background: transparent;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Input
|----------------------------------------------------------------------------*/

/* All input areas */
.jp-InputArea {
  display: table;
  table-layout: fixed;
  width: 100%;
  overflow: hidden;
}

.jp-InputArea-editor {
  display: table-cell;
  overflow: hidden;
  vertical-align: top;

  /* This is the non-active, default styling */
  border: var(--jp-border-width) solid var(--jp-cell-editor-border-color);
  border-radius: 0;
  background: var(--jp-cell-editor-background);
}

.jp-InputPrompt {
  display: table-cell;
  vertical-align: top;
  width: var(--jp-cell-prompt-width);
  color: var(--jp-cell-inprompt-font-color);
  font-family: var(--jp-cell-prompt-font-family);
  padding: var(--jp-code-padding);
  letter-spacing: var(--jp-cell-prompt-letter-spacing);
  opacity: var(--jp-cell-prompt-opacity);
  line-height: var(--jp-code-line-height);
  font-size: var(--jp-code-font-size);
  border: var(--jp-border-width) solid transparent;

  /* Right align prompt text, don't wrap to handle large prompt numbers */
  text-align: right;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;

  /* Disable text selection */
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/*-----------------------------------------------------------------------------
| Mobile
|----------------------------------------------------------------------------*/
@media only screen and (max-width: 760px) {
  .jp-InputArea-editor {
    display: table-row;
    margin-left: var(--jp-notebook-padding);
  }

  .jp-InputPrompt {
    display: table-row;
    text-align: left;
  }
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Placeholder
|----------------------------------------------------------------------------*/

.jp-Placeholder {
  display: table;
  table-layout: fixed;
  width: 100%;
}

.jp-Placeholder-prompt {
  display: table-cell;
  box-sizing: border-box;
}

.jp-Placeholder-content {
  display: table-cell;
  padding: 4px 6px;
  border: 1px solid transparent;
  border-radius: 0;
  background: none;
  box-sizing: border-box;
  cursor: pointer;
}

.jp-Placeholder-contentContainer {
  display: flex;
}

.jp-Placeholder-content:hover,
.jp-InputPlaceholder > .jp-Placeholder-content:hover {
  border-color: var(--jp-layout-color3);
}

.jp-Placeholder-content .jp-MoreHorizIcon {
  width: 32px;
  height: 16px;
  border: 1px solid transparent;
  border-radius: var(--jp-border-radius);
}

.jp-Placeholder-content .jp-MoreHorizIcon:hover {
  border: 1px solid var(--jp-border-color1);
  box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.25);
  background-color: var(--jp-layout-color0);
}

.jp-PlaceholderText {
  white-space: nowrap;
  overflow-x: hidden;
  color: var(--jp-inverse-layout-color3);
  font-family: var(--jp-code-font-family);
}

.jp-InputPlaceholder > .jp-Placeholder-content {
  border-color: var(--jp-cell-editor-border-color);
  background: var(--jp-cell-editor-background);
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Private CSS variables
|----------------------------------------------------------------------------*/

:root {
  --jp-private-cell-scrolling-output-offset: 5px;
}

/*-----------------------------------------------------------------------------
| Cell
|----------------------------------------------------------------------------*/

.jp-Cell {
  padding: var(--jp-cell-padding);
  margin: 0;
  border: none;
  outline: none;
  background: transparent;
}

/*-----------------------------------------------------------------------------
| Common input/output
|----------------------------------------------------------------------------*/

.jp-Cell-inputWrapper,
.jp-Cell-outputWrapper {
  display: flex;
  flex-direction: row;
  padding: 0;
  margin: 0;

  /* Added to reveal the box-shadow on the input and output collapsers. */
  overflow: visible;
}

/* Only input/output areas inside cells */
.jp-Cell-inputArea,
.jp-Cell-outputArea {
  flex: 1 1 auto;
}

/*-----------------------------------------------------------------------------
| Collapser
|----------------------------------------------------------------------------*/

/* Make the output collapser disappear when there is not output, but do so
 * in a manner that leaves it in the layout and preserves its width.
 */
.jp-Cell.jp-mod-noOutputs .jp-Cell-outputCollapser {
  border: none !important;
  background: transparent !important;
}

.jp-Cell:not(.jp-mod-noOutputs) .jp-Cell-outputCollapser {
  min-height: var(--jp-cell-collapser-min-height);
}

/*-----------------------------------------------------------------------------
| Output
|----------------------------------------------------------------------------*/

/* Put a space between input and output when there IS output */
.jp-Cell:not(.jp-mod-noOutputs) .jp-Cell-outputWrapper {
  margin-top: 5px;
}

.jp-CodeCell.jp-mod-outputsScrolled .jp-Cell-outputArea {
  overflow-y: auto;
  max-height: 24em;
  margin-left: var(--jp-private-cell-scrolling-output-offset);
  resize: vertical;
}

.jp-CodeCell.jp-mod-outputsScrolled .jp-Cell-outputArea[style*='height'] {
  max-height: unset;
}

.jp-CodeCell.jp-mod-outputsScrolled .jp-Cell-outputArea::after {
  content: ' ';
  box-shadow: inset 0 0 6px 2px rgb(0 0 0 / 30%);
  width: 100%;
  height: 100%;
  position: sticky;
  bottom: 0;
  top: 0;
  margin-top: -50%;
  float: left;
  display: block;
  pointer-events: none;
}

.jp-CodeCell.jp-mod-outputsScrolled .jp-OutputArea-child {
  padding-top: 6px;
}

.jp-CodeCell.jp-mod-outputsScrolled .jp-OutputArea-prompt {
  width: calc(
    var(--jp-cell-prompt-width) - var(--jp-private-cell-scrolling-output-offset)
  );
}

.jp-CodeCell.jp-mod-outputsScrolled .jp-OutputArea-promptOverlay {
  left: calc(-1 * var(--jp-private-cell-scrolling-output-offset));
}

/*-----------------------------------------------------------------------------
| CodeCell
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| MarkdownCell
|----------------------------------------------------------------------------*/

.jp-MarkdownOutput {
  display: table-cell;
  width: 100%;
  margin-top: 0;
  margin-bottom: 0;
  padding-left: var(--jp-code-padding);
}

.jp-MarkdownOutput.jp-RenderedHTMLCommon {
  overflow: auto;
}

/* collapseHeadingButton (show always if hiddenCellsButton is _not_ shown) */
.jp-collapseHeadingButton {
  display: flex;
  min-height: var(--jp-cell-collapser-min-height);
  font-size: var(--jp-code-font-size);
  position: absolute;
  background-color: transparent;
  background-size: 25px;
  background-repeat: no-repeat;
  background-position-x: center;
  background-position-y: top;
  background-image: var(--jp-icon-caret-down);
  right: 0;
  top: 0;
  bottom: 0;
}

.jp-collapseHeadingButton.jp-mod-collapsed {
  background-image: var(--jp-icon-caret-right);
}

/*
 set the container font size to match that of content
 so that the nested collapse buttons have the right size
*/
.jp-MarkdownCell .jp-InputPrompt {
  font-size: var(--jp-content-font-size1);
}

/*
  Align collapseHeadingButton with cell top header
  The font sizes are identical to the ones in packages/rendermime/style/base.css
*/
.jp-mod-rendered .jp-collapseHeadingButton[data-heading-level='1'] {
  font-size: var(--jp-content-font-size5);
  background-position-y: calc(0.3 * var(--jp-content-font-size5));
}

.jp-mod-rendered .jp-collapseHeadingButton[data-heading-level='2'] {
  font-size: var(--jp-content-font-size4);
  background-position-y: calc(0.3 * var(--jp-content-font-size4));
}

.jp-mod-rendered .jp-collapseHeadingButton[data-heading-level='3'] {
  font-size: var(--jp-content-font-size3);
  background-position-y: calc(0.3 * var(--jp-content-font-size3));
}

.jp-mod-rendered .jp-collapseHeadingButton[data-heading-level='4'] {
  font-size: var(--jp-content-font-size2);
  background-position-y: calc(0.3 * var(--jp-content-font-size2));
}

.jp-mod-rendered .jp-collapseHeadingButton[data-heading-level='5'] {
  font-size: var(--jp-content-font-size1);
  background-position-y: top;
}

.jp-mod-rendered .jp-collapseHeadingButton[data-heading-level='6'] {
  font-size: var(--jp-content-font-size0);
  background-position-y: top;
}

/* collapseHeadingButton (show only on (hover,active) if hiddenCellsButton is shown) */
.jp-Notebook.jp-mod-showHiddenCellsButton .jp-collapseHeadingButton {
  display: none;
}

.jp-Notebook.jp-mod-showHiddenCellsButton
  :is(.jp-MarkdownCell:hover, .jp-mod-active)
  .jp-collapseHeadingButton {
  display: flex;
}

/* showHiddenCellsButton (only show if jp-mod-showHiddenCellsButton is set, which
is a consequence of the showHiddenCellsButton option in Notebook Settings)*/
.jp-Notebook.jp-mod-showHiddenCellsButton .jp-showHiddenCellsButton {
  margin-left: calc(var(--jp-cell-prompt-width) + 2 * var(--jp-code-padding));
  margin-top: var(--jp-code-padding);
  border: 1px solid var(--jp-border-color2);
  background-color: var(--jp-border-color3) !important;
  color: var(--jp-content-font-color0) !important;
  display: flex;
}

.jp-Notebook.jp-mod-showHiddenCellsButton .jp-showHiddenCellsButton:hover {
  background-color: var(--jp-border-color2) !important;
}

.jp-showHiddenCellsButton {
  display: none;
}

/*-----------------------------------------------------------------------------
| Printing
|----------------------------------------------------------------------------*/

/*
Using block instead of flex to allow the use of the break-inside CSS property for
cell outputs.
*/

@media print {
  .jp-Cell-inputWrapper,
  .jp-Cell-outputWrapper {
    display: block;
  }
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Variables
|----------------------------------------------------------------------------*/

:root {
  --jp-notebook-toolbar-padding: 2px 5px 2px 2px;
}

/*-----------------------------------------------------------------------------

/*-----------------------------------------------------------------------------
| Styles
|----------------------------------------------------------------------------*/

.jp-NotebookPanel-toolbar {
  padding: var(--jp-notebook-toolbar-padding);

  /* disable paint containment from lumino 2.0 default strict CSS containment */
  contain: style size !important;
}

.jp-Toolbar-item.jp-Notebook-toolbarCellType .jp-select-wrapper.jp-mod-focused {
  border: none;
  box-shadow: none;
}

.jp-Notebook-toolbarCellTypeDropdown select {
  height: 24px;
  font-size: var(--jp-ui-font-size1);
  line-height: 14px;
  border-radius: 0;
  display: block;
}

.jp-Notebook-toolbarCellTypeDropdown span {
  top: 5px !important;
}

.jp-Toolbar-responsive-popup {
  position: absolute;
  height: fit-content;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: flex-end;
  border-bottom: var(--jp-border-width) solid var(--jp-toolbar-border-color);
  box-shadow: var(--jp-toolbar-box-shadow);
  background: var(--jp-toolbar-background);
  min-height: var(--jp-toolbar-micro-height);
  padding: var(--jp-notebook-toolbar-padding);
  z-index: 1;
  right: 0;
  top: 0;
}

.jp-Toolbar > .jp-Toolbar-responsive-opener {
  margin-left: auto;
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Variables
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------

/*-----------------------------------------------------------------------------
| Styles
|----------------------------------------------------------------------------*/

.jp-Notebook-ExecutionIndicator {
  position: relative;
  display: inline-block;
  height: 100%;
  z-index: 9997;
}

.jp-Notebook-ExecutionIndicator-tooltip {
  visibility: hidden;
  height: auto;
  width: max-content;
  width: -moz-max-content;
  background-color: var(--jp-layout-color2);
  color: var(--jp-ui-font-color1);
  text-align: justify;
  border-radius: 6px;
  padding: 0 5px;
  position: fixed;
  display: table;
}

.jp-Notebook-ExecutionIndicator-tooltip.up {
  transform: translateX(-50%) translateY(-100%) translateY(-32px);
}

.jp-Notebook-ExecutionIndicator-tooltip.down {
  transform: translateX(calc(-100% + 16px)) translateY(5px);
}

.jp-Notebook-ExecutionIndicator-tooltip.hidden {
  display: none;
}

.jp-Notebook-ExecutionIndicator:hover .jp-Notebook-ExecutionIndicator-tooltip {
  visibility: visible;
}

.jp-Notebook-ExecutionIndicator span {
  font-size: var(--jp-ui-font-size1);
  font-family: var(--jp-ui-font-family);
  color: var(--jp-ui-font-color1);
  line-height: 24px;
  display: block;
}

.jp-Notebook-ExecutionIndicator-progress-bar {
  display: flex;
  justify-content: center;
  height: 100%;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

/*
 * Execution indicator
 */
.jp-tocItem-content::after {
  content: '';

  /* Must be identical to form a circle */
  width: 12px;
  height: 12px;
  background: none;
  border: none;
  position: absolute;
  right: 0;
}

.jp-tocItem-content[data-running='0']::after {
  border-radius: 50%;
  border: var(--jp-border-width) solid var(--jp-inverse-layout-color3);
  background: none;
}

.jp-tocItem-content[data-running='1']::after {
  border-radius: 50%;
  border: var(--jp-border-width) solid var(--jp-inverse-layout-color3);
  background-color: var(--jp-inverse-layout-color3);
}

.jp-tocItem-content[data-running='0'],
.jp-tocItem-content[data-running='1'] {
  margin-right: 12px;
}

/*
 * Copyright (c) Jupyter Development Team.
 * Distributed under the terms of the Modified BSD License.
 */

.jp-Notebook-footer {
  height: 27px;
  margin-left: calc(
    var(--jp-cell-prompt-width) + var(--jp-cell-collapser-width) +
      var(--jp-cell-padding)
  );
  width: calc(
    100% -
      (
        var(--jp-cell-prompt-width) + var(--jp-cell-collapser-width) +
          var(--jp-cell-padding) + var(--jp-cell-padding)
      )
  );
  border: var(--jp-border-width) solid var(--jp-cell-editor-border-color);
  color: var(--jp-ui-font-color3);
  margin-top: 6px;
  background: none;
  cursor: pointer;
}

.jp-Notebook-footer:focus {
  border-color: var(--jp-cell-editor-active-border-color);
}

/* For devices that support hovering, hide footer until hover */
@media (hover: hover) {
  .jp-Notebook-footer {
    opacity: 0;
  }

  .jp-Notebook-footer:focus,
  .jp-Notebook-footer:hover {
    opacity: 1;
  }
}

/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| Imports
|----------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------
| CSS variables
|----------------------------------------------------------------------------*/

:root {
  --jp-side-by-side-output-size: 1fr;
  --jp-side-by-side-resized-cell: var(--jp-side-by-side-output-size);
  --jp-private-notebook-dragImage-width: 304px;
  --jp-private-notebook-dragImage-height: 36px;
  --jp-private-notebook-selected-color: var(--md-blue-400);
  --jp-private-notebook-active-color: var(--md-green-400);
}

/*-----------------------------------------------------------------------------
| Notebook
|----------------------------------------------------------------------------*/

/* stylelint-disable selector-max-class */

.jp-NotebookPanel {
  display: block;
  height: 100%;
}

.jp-NotebookPanel.jp-Document {
  min-width: 240px;
  min-height: 120px;
}

.jp-Notebook {
  padding: var(--jp-notebook-padding);
  outline: none;
  overflow: auto;
  background: var(--jp-layout-color0);
}

.jp-Notebook.jp-mod-scrollPastEnd::after {
  display: block;
  content: '';
  min-height: var(--jp-notebook-scroll-padding);
}

.jp-MainAreaWidget-ContainStrict .jp-Notebook * {
  contain: strict;
}

.jp-Notebook .jp-Cell {
  overflow: visible;
}

.jp-Notebook .jp-Cell .jp-InputPrompt {
  cursor: move;
}

/*-----------------------------------------------------------------------------
| Notebook state related styling
|
| The notebook and cells each have states, here are the possibilities:
|
| - Notebook
|   - Command
|   - Edit
| - Cell
|   - None
|   - Active (only one can be active)
|   - Selected (the cells actions are applied to)
|   - Multiselected (when multiple selected, the cursor)
|   - No outputs
|----------------------------------------------------------------------------*/

/* Command or edit modes */

.jp-Notebook .jp-Cell:not(.jp-mod-active) .jp-InputPrompt {
  opacity: var(--jp-cell-prompt-not-active-opacity);
  color: var(--jp-cell-prompt-not-active-font-color);
}

.jp-Notebook .jp-Cell:not(.jp-mod-active) .jp-OutputPrompt {
  opacity: var(--jp-cell-prompt-not-active-opacity);
  color: var(--jp-cell-prompt-not-active-font-color);
}

/* cell is active */
.jp-Notebook .jp-Cell.jp-mod-active .jp-Collapser {
  background: var(--jp-brand-color1);
}

/* cell is dirty */
.jp-Notebook .jp-Cell.jp-mod-dirty .jp-InputPrompt {
  color: var(--jp-warn-color1);
}

.jp-Notebook .jp-Cell.jp-mod-dirty .jp-InputPrompt::before {
  color: var(--jp-warn-color1);
  content: '•';
}

.jp-Notebook .jp-Cell.jp-mod-active.jp-mod-dirty .jp-Collapser {
  background: var(--jp-warn-color1);
}

/* collapser is hovered */
.jp-Notebook .jp-Cell .jp-Collapser:hover {
  box-shadow: var(--jp-elevation-z2);
  background: var(--jp-brand-color1);
  opacity: var(--jp-cell-collapser-not-active-hover-opacity);
}

/* cell is active and collapser is hovered */
.jp-Notebook .jp-Cell.jp-mod-active .jp-Collapser:hover {
  background: var(--jp-brand-color0);
  opacity: 1;
}

/* Command mode */

.jp-Notebook.jp-mod-commandMode .jp-Cell.jp-mod-selected {
  background: var(--jp-notebook-multiselected-color);
}

.jp-Notebook.jp-mod-commandMode
  .jp-Cell.jp-mod-active.jp-mod-selected:not(.jp-mod-multiSelected) {
  background: transparent;
}

/* Edit mode */

.jp-Notebook.jp-mod-editMode .jp-Cell.jp-mod-active .jp-InputArea-editor {
  border: var(--jp-border-width) solid var(--jp-cell-editor-active-border-color);
  box-shadow: var(--jp-input-box-shadow);
  background-color: var(--jp-cell-editor-active-background);
}

/*-----------------------------------------------------------------------------
| Notebook drag and drop
|----------------------------------------------------------------------------*/

.jp-Notebook-cell.jp-mod-dropSource {
  opacity: 0.5;
}

.jp-Notebook-cell.jp-mod-dropTarget,
.jp-Notebook.jp-mod-commandMode
  .jp-Notebook-cell.jp-mod-active.jp-mod-selected.jp-mod-dropTarget {
  border-top-color: var(--jp-private-notebook-selected-color);
  border-top-style: solid;
  border-top-width: 2px;
}

.jp-dragImage {
  display: block;
  flex-direction: row;
  width: var(--jp-private-notebook-dragImage-width);
  height: var(--jp-private-notebook-dragImage-height);
  border: var(--jp-border-width) solid var(--jp-cell-editor-border-color);
  background: var(--jp-cell-editor-background);
  overflow: visible;
}

.jp-dragImage-singlePrompt {
  box-shadow: 2px 2px 4px 0 rgba(0, 0, 0, 0.12);
}

.jp-dragImage .jp-dragImage-content {
  flex: 1 1 auto;
  z-index: 2;
  font-size: var(--jp-code-font-size);
  font-family: var(--jp-code-font-family);
  line-height: var(--jp-code-line-height);
  padding: var(--jp-code-padding);
  border: var(--jp-border-width) solid var(--jp-cell-editor-border-color);
  background: var(--jp-cell-editor-background-color);
  color: var(--jp-content-font-color3);
  text-align: left;
  margin: 4px 4px 4px 0;
}

.jp-dragImage .jp-dragImage-prompt {
  flex: 0 0 auto;
  min-width: 36px;
  color: var(--jp-cell-inprompt-font-color);
  padding: var(--jp-code-padding);
  padding-left: 12px;
  font-family: var(--jp-cell-prompt-font-family);
  letter-spacing: var(--jp-cell-prompt-letter-spacing);
  line-height: 1.9;
  font-size: var(--jp-code-font-size);
  border: var(--jp-border-width) solid transparent;
}

.jp-dragImage-multipleBack {
  z-index: -1;
  position: absolute;
  height: 32px;
  width: 300px;
  top: 8px;
  left: 8px;
  background: var(--jp-layout-color2);
  border: var(--jp-border-width) solid var(--jp-input-border-color);
  box-shadow: 2px 2px 4px 0 rgba(0, 0, 0, 0.12);
}

/*-----------------------------------------------------------------------------
| Cell toolbar
|----------------------------------------------------------------------------*/

.jp-NotebookTools {
  display: block;
  min-width: var(--jp-sidebar-min-width);
  color: var(--jp-ui-font-color1);
  background: var(--jp-layout-color1);

  /* This is needed so that all font sizing of children done in ems is
    * relative to this base size */
  font-size: var(--jp-ui-font-size1);
  overflow: auto;
}

.jp-ActiveCellTool {
  padding: 12px 0;
  display: flex;
}

.jp-ActiveCellTool-Content {
  flex: 1 1 auto;
}

.jp-ActiveCellTool .jp-ActiveCellTool-CellContent {
  background: var(--jp-cell-editor-background);
  border: var(--jp-border-width) solid var(--jp-cell-editor-border-color);
  border-radius: 0;
  min-height: 29px;
}

.jp-ActiveCellTool .jp-InputPrompt {
  min-width: calc(var(--jp-cell-prompt-width) * 0.75);
}

.jp-ActiveCellTool-CellContent > pre {
  padding: 5px 4px;
  margin: 0;
  white-space: normal;
}

.jp-MetadataEditorTool {
  flex-direction: column;
  padding: 12px 0;
}

.jp-RankedPanel > :not(:first-child) {
  margin-top: 12px;
}

.jp-KeySelector select.jp-mod-styled {
  font-size: var(--jp-ui-font-size1);
  color: var(--jp-ui-font-color0);
  border: var(--jp-border-width) solid var(--jp-border-color1);
}

.jp-KeySelector label,
.jp-MetadataEditorTool label,
.jp-NumberSetter label {
  line-height: 1.4;
}

.jp-NotebookTools .jp-select-wrapper {
  margin-top: 4px;
  margin-bottom: 0;
}

.jp-NumberSetter input {
  width: 100%;
  margin-top: 4px;
}

.jp-NotebookTools .jp-Collapse {
  margin-top: 16px;
}

/*-----------------------------------------------------------------------------
| Presentation Mode (.jp-mod-presentationMode)
|----------------------------------------------------------------------------*/

.jp-mod-presentationMode .jp-Notebook {
  --jp-content-font-size1: var(--jp-content-presentation-font-size1);
  --jp-code-font-size: var(--jp-code-presentation-font-size);
}

.jp-mod-presentationMode .jp-Notebook .jp-Cell .jp-InputPrompt,
.jp-mod-presentationMode .jp-Notebook .jp-Cell .jp-OutputPrompt {
  flex: 0 0 110px;
}

/*-----------------------------------------------------------------------------
| Side-by-side Mode (.jp-mod-sideBySide)
|----------------------------------------------------------------------------*/
.jp-mod-sideBySide.jp-Notebook .jp-Notebook-cell {
  margin-top: 3em;
  margin-bottom: 3em;
  margin-left: 5%;
  margin-right: 5%;
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell {
  display: grid;
  grid-template-columns: minmax(0, 1fr) min-content minmax(
      0,
      var(--jp-side-by-side-output-size)
    );
  grid-template-rows: auto minmax(0, 1fr) auto;
  grid-template-areas:
    'header header header'
    'input handle output'
    'footer footer footer';
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell.jp-mod-resizedCell {
  grid-template-columns: minmax(0, 1fr) min-content minmax(
      0,
      var(--jp-side-by-side-resized-cell)
    );
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell .jp-CellHeader {
  grid-area: header;
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell .jp-Cell-inputWrapper {
  grid-area: input;
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell .jp-Cell-outputWrapper {
  /* overwrite the default margin (no vertical separation needed in side by side move */
  margin-top: 0;
  grid-area: output;
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell .jp-CellFooter {
  grid-area: footer;
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell .jp-CellResizeHandle {
  grid-area: handle;
  user-select: none;
  display: block;
  height: 100%;
  cursor: ew-resize;
  padding: 0 var(--jp-cell-padding);
}

.jp-mod-sideBySide.jp-Notebook .jp-CodeCell .jp-CellResizeHandle::after {
  content: '';
  display: block;
  background: var(--jp-border-color2);
  height: 100%;
  width: 5px;
}

.jp-mod-sideBySide.jp-Notebook
  .jp-CodeCell.jp-mod-resizedCell
  .jp-CellResizeHandle::after {
  background: var(--jp-border-color0);
}

.jp-CellResizeHandle {
  display: none;
}

/*-----------------------------------------------------------------------------
| Placeholder
|----------------------------------------------------------------------------*/

.jp-Cell-Placeholder {
  padding-left: 55px;
}

.jp-Cell-Placeholder-wrapper {
  background: #fff;
  border: 1px solid;
  border-color: #e5e6e9 #dfe0e4 #d0d1d5;
  border-radius: 4px;
  -webkit-border-radius: 4px;
  margin: 10px 15px;
}

.jp-Cell-Placeholder-wrapper-inner {
  padding: 15px;
  position: relative;
}

.jp-Cell-Placeholder-wrapper-body {
  background-repeat: repeat;
  background-size: 50% auto;
}

.jp-Cell-Placeholder-wrapper-body div {
  background: #f6f7f8;
  background-image: -webkit-linear-gradient(
    left,
    #f6f7f8 0%,
    #edeef1 20%,
    #f6f7f8 40%,
    #f6f7f8 100%
  );
  background-repeat: no-repeat;
  background-size: 800px 104px;
  height: 104px;
  position: absolute;
  right: 15px;
  left: 15px;
  top: 15px;
}

div.jp-Cell-Placeholder-h1 {
  top: 20px;
  height: 20px;
  left: 15px;
  width: 150px;
}

div.jp-Cell-Placeholder-h2 {
  left: 15px;
  top: 50px;
  height: 10px;
  width: 100px;
}

div.jp-Cell-Placeholder-content-1,
div.jp-Cell-Placeholder-content-2,
div.jp-Cell-Placeholder-content-3 {
  left: 15px;
  right: 15px;
  height: 10px;
}

div.jp-Cell-Placeholder-content-1 {
  top: 100px;
}

div.jp-Cell-Placeholder-content-2 {
  top: 120px;
}

div.jp-Cell-Placeholder-content-3 {
  top: 140px;
}

</style>
<style type="text/css">
/*-----------------------------------------------------------------------------
| Copyright (c) Jupyter Development Team.
| Distributed under the terms of the Modified BSD License.
|----------------------------------------------------------------------------*/

/*
The following CSS variables define the main, public API for styling JupyterLab.
These variables should be used by all plugins wherever possible. In other
words, plugins should not define custom colors, sizes, etc unless absolutely
necessary. This enables users to change the visual theme of JupyterLab
by changing these variables.

Many variables appear in an ordered sequence (0,1,2,3). These sequences
are designed to work well together, so for example, `--jp-border-color1` should
be used with `--jp-layout-color1`. The numbers have the following meanings:

* 0: super-primary, reserved for special emphasis
* 1: primary, most important under normal situations
* 2: secondary, next most important under normal situations
* 3: tertiary, next most important under normal situations

Throughout JupyterLab, we are mostly following principles from Google's
Material Design when selecting colors. We are not, however, following
all of MD as it is not optimized for dense, information rich UIs.
*/

:root {
  /* Elevation
   *
   * We style box-shadows using Material Design's idea of elevation. These particular numbers are taken from here:
   *
   * https://github.com/material-components/material-components-web
   * https://material-components-web.appspot.com/elevation.html
   */

  --jp-shadow-base-lightness: 0;
  --jp-shadow-umbra-color: rgba(
    var(--jp-shadow-base-lightness),
    var(--jp-shadow-base-lightness),
    var(--jp-shadow-base-lightness),
    0.2
  );
  --jp-shadow-penumbra-color: rgba(
    var(--jp-shadow-base-lightness),
    var(--jp-shadow-base-lightness),
    var(--jp-shadow-base-lightness),
    0.14
  );
  --jp-shadow-ambient-color: rgba(
    var(--jp-shadow-base-lightness),
    var(--jp-shadow-base-lightness),
    var(--jp-shadow-base-lightness),
    0.12
  );
  --jp-elevation-z0: none;
  --jp-elevation-z1: 0 2px 1px -1px var(--jp-shadow-umbra-color),
    0 1px 1px 0 var(--jp-shadow-penumbra-color),
    0 1px 3px 0 var(--jp-shadow-ambient-color);
  --jp-elevation-z2: 0 3px 1px -2px var(--jp-shadow-umbra-color),
    0 2px 2px 0 var(--jp-shadow-penumbra-color),
    0 1px 5px 0 var(--jp-shadow-ambient-color);
  --jp-elevation-z4: 0 2px 4px -1px var(--jp-shadow-umbra-color),
    0 4px 5px 0 var(--jp-shadow-penumbra-color),
    0 1px 10px 0 var(--jp-shadow-ambient-color);
  --jp-elevation-z6: 0 3px 5px -1px var(--jp-shadow-umbra-color),
    0 6px 10px 0 var(--jp-shadow-penumbra-color),
    0 1px 18px 0 var(--jp-shadow-ambient-color);
  --jp-elevation-z8: 0 5px 5px -3px var(--jp-shadow-umbra-color),
    0 8px 10px 1px var(--jp-shadow-penumbra-color),
    0 3px 14px 2px var(--jp-shadow-ambient-color);
  --jp-elevation-z12: 0 7px 8px -4px var(--jp-shadow-umbra-color),
    0 12px 17px 2px var(--jp-shadow-penumbra-color),
    0 5px 22px 4px var(--jp-shadow-ambient-color);
  --jp-elevation-z16: 0 8px 10px -5px var(--jp-shadow-umbra-color),
    0 16px 24px 2px var(--jp-shadow-penumbra-color),
    0 6px 30px 5px var(--jp-shadow-ambient-color);
  --jp-elevation-z20: 0 10px 13px -6px var(--jp-shadow-umbra-color),
    0 20px 31px 3px var(--jp-shadow-penumbra-color),
    0 8px 38px 7px var(--jp-shadow-ambient-color);
  --jp-elevation-z24: 0 11px 15px -7px var(--jp-shadow-umbra-color),
    0 24px 38px 3px var(--jp-shadow-penumbra-color),
    0 9px 46px 8px var(--jp-shadow-ambient-color);

  /* Borders
   *
   * The following variables, specify the visual styling of borders in JupyterLab.
   */

  --jp-border-width: 1px;
  --jp-border-color0: var(--md-grey-400);
  --jp-border-color1: var(--md-grey-400);
  --jp-border-color2: var(--md-grey-300);
  --jp-border-color3: var(--md-grey-200);
  --jp-inverse-border-color: var(--md-grey-600);
  --jp-border-radius: 2px;

  /* UI Fonts
   *
   * The UI font CSS variables are used for the typography all of the JupyterLab
   * user interface elements that are not directly user generated content.
   *
   * The font sizing here is done assuming that the body font size of --jp-ui-font-size1
   * is applied to a parent element. When children elements, such as headings, are sized
   * in em all things will be computed relative to that body size.
   */

  --jp-ui-font-scale-factor: 1.2;
  --jp-ui-font-size0: 0.83333em;
  --jp-ui-font-size1: 13px; /* Base font size */
  --jp-ui-font-size2: 1.2em;
  --jp-ui-font-size3: 1.44em;
  --jp-ui-font-family: system-ui, -apple-system, blinkmacsystemfont, 'Segoe UI',
    helvetica, arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
    'Segoe UI Symbol';

  /*
   * Use these font colors against the corresponding main layout colors.
   * In a light theme, these go from dark to light.
   */

  /* Defaults use Material Design specification */
  --jp-ui-font-color0: rgba(0, 0, 0, 1);
  --jp-ui-font-color1: rgba(0, 0, 0, 0.87);
  --jp-ui-font-color2: rgba(0, 0, 0, 0.54);
  --jp-ui-font-color3: rgba(0, 0, 0, 0.38);

  /*
   * Use these against the brand/accent/warn/error colors.
   * These will typically go from light to darker, in both a dark and light theme.
   */

  --jp-ui-inverse-font-color0: rgba(255, 255, 255, 1);
  --jp-ui-inverse-font-color1: rgba(255, 255, 255, 1);
  --jp-ui-inverse-font-color2: rgba(255, 255, 255, 0.7);
  --jp-ui-inverse-font-color3: rgba(255, 255, 255, 0.5);

  /* Content Fonts
   *
   * Content font variables are used for typography of user generated content.
   *
   * The font sizing here is done assuming that the body font size of --jp-content-font-size1
   * is applied to a parent element. When children elements, such as headings, are sized
   * in em all things will be computed relative to that body size.
   */

  --jp-content-line-height: 1.6;
  --jp-content-font-scale-factor: 1.2;
  --jp-content-font-size0: 0.83333em;
  --jp-content-font-size1: 14px; /* Base font size */
  --jp-content-font-size2: 1.2em;
  --jp-content-font-size3: 1.44em;
  --jp-content-font-size4: 1.728em;
  --jp-content-font-size5: 2.0736em;

  /* This gives a magnification of about 125% in presentation mode over normal. */
  --jp-content-presentation-font-size1: 17px;
  --jp-content-heading-line-height: 1;
  --jp-content-heading-margin-top: 1.2em;
  --jp-content-heading-margin-bottom: 0.8em;
  --jp-content-heading-font-weight: 500;

  /* Defaults use Material Design specification */
  --jp-content-font-color0: rgba(0, 0, 0, 1);
  --jp-content-font-color1: rgba(0, 0, 0, 0.87);
  --jp-content-font-color2: rgba(0, 0, 0, 0.54);
  --jp-content-font-color3: rgba(0, 0, 0, 0.38);
  --jp-content-link-color: var(--md-blue-900);
  --jp-content-font-family: system-ui, -apple-system, blinkmacsystemfont,
    'Segoe UI', helvetica, arial, sans-serif, 'Apple Color Emoji',
    'Segoe UI Emoji', 'Segoe UI Symbol';

  /*
   * Code Fonts
   *
   * Code font variables are used for typography of code and other monospaces content.
   */

  --jp-code-font-size: 13px;
  --jp-code-line-height: 1.3077; /* 17px for 13px base */
  --jp-code-padding: 5px; /* 5px for 13px base, codemirror highlighting needs integer px value */
  --jp-code-font-family-default: menlo, consolas, 'DejaVu Sans Mono', monospace;
  --jp-code-font-family: var(--jp-code-font-family-default);

  /* This gives a magnification of about 125% in presentation mode over normal. */
  --jp-code-presentation-font-size: 16px;

  /* may need to tweak cursor width if you change font size */
  --jp-code-cursor-width0: 1.4px;
  --jp-code-cursor-width1: 2px;
  --jp-code-cursor-width2: 4px;

  /* Layout
   *
   * The following are the main layout colors use in JupyterLab. In a light
   * theme these would go from light to dark.
   */

  --jp-layout-color0: white;
  --jp-layout-color1: white;
  --jp-layout-color2: var(--md-grey-200);
  --jp-layout-color3: var(--md-grey-400);
  --jp-layout-color4: var(--md-grey-600);

  /* Inverse Layout
   *
   * The following are the inverse layout colors use in JupyterLab. In a light
   * theme these would go from dark to light.
   */

  --jp-inverse-layout-color0: #111;
  --jp-inverse-layout-color1: var(--md-grey-900);
  --jp-inverse-layout-color2: var(--md-grey-800);
  --jp-inverse-layout-color3: var(--md-grey-700);
  --jp-inverse-layout-color4: var(--md-grey-600);

  /* Brand/accent */

  --jp-brand-color0: var(--md-blue-900);
  --jp-brand-color1: var(--md-blue-700);
  --jp-brand-color2: var(--md-blue-300);
  --jp-brand-color3: var(--md-blue-100);
  --jp-brand-color4: var(--md-blue-50);
  --jp-accent-color0: var(--md-green-900);
  --jp-accent-color1: var(--md-green-700);
  --jp-accent-color2: var(--md-green-300);
  --jp-accent-color3: var(--md-green-100);

  /* State colors (warn, error, success, info) */

  --jp-warn-color0: var(--md-orange-900);
  --jp-warn-color1: var(--md-orange-700);
  --jp-warn-color2: var(--md-orange-300);
  --jp-warn-color3: var(--md-orange-100);
  --jp-error-color0: var(--md-red-900);
  --jp-error-color1: var(--md-red-700);
  --jp-error-color2: var(--md-red-300);
  --jp-error-color3: var(--md-red-100);
  --jp-success-color0: var(--md-green-900);
  --jp-success-color1: var(--md-green-700);
  --jp-success-color2: var(--md-green-300);
  --jp-success-color3: var(--md-green-100);
  --jp-info-color0: var(--md-cyan-900);
  --jp-info-color1: var(--md-cyan-700);
  --jp-info-color2: var(--md-cyan-300);
  --jp-info-color3: var(--md-cyan-100);

  /* Cell specific styles */

  --jp-cell-padding: 5px;
  --jp-cell-collapser-width: 8px;
  --jp-cell-collapser-min-height: 20px;
  --jp-cell-collapser-not-active-hover-opacity: 0.6;
  --jp-cell-editor-background: var(--md-grey-100);
  --jp-cell-editor-border-color: var(--md-grey-300);
  --jp-cell-editor-box-shadow: inset 0 0 2px var(--md-blue-300);
  --jp-cell-editor-active-background: var(--jp-layout-color0);
  --jp-cell-editor-active-border-color: var(--jp-brand-color1);
  --jp-cell-prompt-width: 64px;
  --jp-cell-prompt-font-family: var(--jp-code-font-family-default);
  --jp-cell-prompt-letter-spacing: 0;
  --jp-cell-prompt-opacity: 1;
  --jp-cell-prompt-not-active-opacity: 0.5;
  --jp-cell-prompt-not-active-font-color: var(--md-grey-700);

  /* A custom blend of MD grey and blue 600
   * See https://meyerweb.com/eric/tools/color-blend/#546E7A:1E88E5:5:hex */
  --jp-cell-inprompt-font-color: #307fc1;

  /* A custom blend of MD grey and orange 600
   * https://meyerweb.com/eric/tools/color-blend/#546E7A:F4511E:5:hex */
  --jp-cell-outprompt-font-color: #bf5b3d;

  /* Notebook specific styles */

  --jp-notebook-padding: 10px;
  --jp-notebook-select-background: var(--jp-layout-color1);
  --jp-notebook-multiselected-color: var(--md-blue-50);

  /* The scroll padding is calculated to fill enough space at the bottom of the
  notebook to show one single-line cell (with appropriate padding) at the top
  when the notebook is scrolled all the way to the bottom. We also subtract one
  pixel so that no scrollbar appears if we have just one single-line cell in the
  notebook. This padding is to enable a 'scroll past end' feature in a notebook.
  */
  --jp-notebook-scroll-padding: calc(
    100% - var(--jp-code-font-size) * var(--jp-code-line-height) -
      var(--jp-code-padding) - var(--jp-cell-padding) - 1px
  );

  /* Rendermime styles */

  --jp-rendermime-error-background: #fdd;
  --jp-rendermime-table-row-background: var(--md-grey-100);
  --jp-rendermime-table-row-hover-background: var(--md-light-blue-50);

  /* Dialog specific styles */

  --jp-dialog-background: rgba(0, 0, 0, 0.25);

  /* Console specific styles */

  --jp-console-padding: 10px;

  /* Toolbar specific styles */

  --jp-toolbar-border-color: var(--jp-border-color1);
  --jp-toolbar-micro-height: 8px;
  --jp-toolbar-background: var(--jp-layout-color1);
  --jp-toolbar-box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.24);
  --jp-toolbar-header-margin: 4px 4px 0 4px;
  --jp-toolbar-active-background: var(--md-grey-300);

  /* Statusbar specific styles */

  --jp-statusbar-height: 24px;

  /* Input field styles */

  --jp-input-box-shadow: inset 0 0 2px var(--md-blue-300);
  --jp-input-active-background: var(--jp-layout-color1);
  --jp-input-hover-background: var(--jp-layout-color1);
  --jp-input-background: var(--md-grey-100);
  --jp-input-border-color: var(--jp-inverse-border-color);
  --jp-input-active-border-color: var(--jp-brand-color1);
  --jp-input-active-box-shadow-color: rgba(19, 124, 189, 0.3);

  /* General editor styles */

  --jp-editor-selected-background: #d9d9d9;
  --jp-editor-selected-focused-background: #d7d4f0;
  --jp-editor-cursor-color: var(--jp-ui-font-color0);

  /* Code mirror specific styles */

  --jp-mirror-editor-keyword-color: #008000;
  --jp-mirror-editor-atom-color: #88f;
  --jp-mirror-editor-number-color: #080;
  --jp-mirror-editor-def-color: #00f;
  --jp-mirror-editor-variable-color: var(--md-grey-900);
  --jp-mirror-editor-variable-2-color: rgb(0, 54, 109);
  --jp-mirror-editor-variable-3-color: #085;
  --jp-mirror-editor-punctuation-color: #05a;
  --jp-mirror-editor-property-color: #05a;
  --jp-mirror-editor-operator-color: #a2f;
  --jp-mirror-editor-comment-color: #408080;
  --jp-mirror-editor-string-color: #ba2121;
  --jp-mirror-editor-string-2-color: #708;
  --jp-mirror-editor-meta-color: #a2f;
  --jp-mirror-editor-qualifier-color: #555;
  --jp-mirror-editor-builtin-color: #008000;
  --jp-mirror-editor-bracket-color: #997;
  --jp-mirror-editor-tag-color: #170;
  --jp-mirror-editor-attribute-color: #00c;
  --jp-mirror-editor-header-color: blue;
  --jp-mirror-editor-quote-color: #090;
  --jp-mirror-editor-link-color: #00c;
  --jp-mirror-editor-error-color: #f00;
  --jp-mirror-editor-hr-color: #999;

  /*
    RTC user specific colors.
    These colors are used for the cursor, username in the editor,
    and the icon of the user.
  */

  --jp-collaborator-color1: #ffad8e;
  --jp-collaborator-color2: #dac83d;
  --jp-collaborator-color3: #72dd76;
  --jp-collaborator-color4: #00e4d0;
  --jp-collaborator-color5: #45d4ff;
  --jp-collaborator-color6: #e2b1ff;
  --jp-collaborator-color7: #ff9de6;

  /* Vega extension styles */

  --jp-vega-background: white;

  /* Sidebar-related styles */

  --jp-sidebar-min-width: 250px;

  /* Search-related styles */

  --jp-search-toggle-off-opacity: 0.5;
  --jp-search-toggle-hover-opacity: 0.8;
  --jp-search-toggle-on-opacity: 1;
  --jp-search-selected-match-background-color: rgb(245, 200, 0);
  --jp-search-selected-match-color: black;
  --jp-search-unselected-match-background-color: var(
    --jp-inverse-layout-color0
  );
  --jp-search-unselected-match-color: var(--jp-ui-inverse-font-color0);

  /* Icon colors that work well with light or dark backgrounds */
  --jp-icon-contrast-color0: var(--md-purple-600);
  --jp-icon-contrast-color1: var(--md-green-600);
  --jp-icon-contrast-color2: var(--md-pink-600);
  --jp-icon-contrast-color3: var(--md-blue-600);

  /* Button colors */
  --jp-accept-color-normal: var(--md-blue-700);
  --jp-accept-color-hover: var(--md-blue-800);
  --jp-accept-color-active: var(--md-blue-900);
  --jp-warn-color-normal: var(--md-red-700);
  --jp-warn-color-hover: var(--md-red-800);
  --jp-warn-color-active: var(--md-red-900);
  --jp-reject-color-normal: var(--md-grey-600);
  --jp-reject-color-hover: var(--md-grey-700);
  --jp-reject-color-active: var(--md-grey-800);

  /* File or activity icons and switch semantic variables */
  --jp-jupyter-icon-color: #f37626;
  --jp-notebook-icon-color: #f37626;
  --jp-json-icon-color: var(--md-orange-700);
  --jp-console-icon-background-color: var(--md-blue-700);
  --jp-console-icon-color: white;
  --jp-terminal-icon-background-color: var(--md-grey-800);
  --jp-terminal-icon-color: var(--md-grey-200);
  --jp-text-editor-icon-color: var(--md-grey-700);
  --jp-inspector-icon-color: var(--md-grey-700);
  --jp-switch-color: var(--md-grey-400);
  --jp-switch-true-position-color: var(--md-orange-900);
}
</style>
<style type="text/css">
/* Force rendering true colors when outputing to pdf */
* {
  -webkit-print-color-adjust: exact;
}

/* Misc */
a.anchor-link {
  display: none;
}

/* Input area styling */
.jp-InputArea {
  overflow: hidden;
}

.jp-InputArea-editor {
  overflow: hidden;
}

.cm-editor.cm-s-jupyter .highlight pre {
/* weird, but --jp-code-padding defined to be 5px but 4px horizontal padding is hardcoded for pre.cm-line */
  padding: var(--jp-code-padding) 4px;
  margin: 0;

  font-family: inherit;
  font-size: inherit;
  line-height: inherit;
  color: inherit;

}

.jp-OutputArea-output pre {
  line-height: inherit;
  font-family: inherit;
}

.jp-RenderedText pre {
  color: var(--jp-content-font-color1);
  font-size: var(--jp-code-font-size);
}

/* Hiding the collapser by default */
.jp-Collapser {
  display: none;
}

@page {
    margin: 0.5in; /* Margin for each printed piece of paper */
}

@media print {
  .jp-Cell-inputWrapper,
  .jp-Cell-outputWrapper {
    display: block;
  }
}
</style>
<!-- Load mathjax -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/latest.js?config=TeX-AMS_CHTML-full,Safe"> </script>
<!-- MathJax configuration -->
<script type="text/x-mathjax-config">
    init_mathjax = function() {
        if (window.MathJax) {
        // MathJax loaded
            MathJax.Hub.Config({
                TeX: {
                    equationNumbers: {
                    autoNumber: "AMS",
                    useLabelIds: true
                    }
                },
                tex2jax: {
                    inlineMath: [ ['$','$'], ["\\(","\\)"] ],
                    displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
                    processEscapes: true,
                    processEnvironments: true
                },
                displayAlign: 'center',
                messageStyle: 'none',
                CommonHTML: {
                    linebreaks: {
                    automatic: true
                    }
                }
            });

            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        }
    }
    init_mathjax();
    </script>
<!-- End of mathjax configuration --><script type="module">
  document.addEventListener("DOMContentLoaded", async () => {
    const diagrams = document.querySelectorAll(".jp-Mermaid > pre.mermaid");
    // do not load mermaidjs if not needed
    if (!diagrams.length) {
      return;
    }
    const mermaid = (await import("https://cdnjs.cloudflare.com/ajax/libs/mermaid/10.7.0/mermaid.esm.min.mjs")).default;
    const parser = new DOMParser();

    mermaid.initialize({
      maxTextSize: 100000,
      maxEdges: 100000,
      startOnLoad: false,
      fontFamily: window
        .getComputedStyle(document.body)
        .getPropertyValue("--jp-ui-font-family"),
      theme: document.querySelector("body[data-jp-theme-light='true']")
        ? "default"
        : "dark",
    });

    let _nextMermaidId = 0;

    function makeMermaidImage(svg) {
      const img = document.createElement("img");
      const doc = parser.parseFromString(svg, "image/svg+xml");
      const svgEl = doc.querySelector("svg");
      const { maxWidth } = svgEl?.style || {};
      const firstTitle = doc.querySelector("title");
      const firstDesc = doc.querySelector("desc");

      img.setAttribute("src", `data:image/svg+xml,${encodeURIComponent(svg)}`);
      if (maxWidth) {
        img.width = parseInt(maxWidth);
      }
      if (firstTitle) {
        img.setAttribute("alt", firstTitle.textContent);
      }
      if (firstDesc) {
        const caption = document.createElement("figcaption");
        caption.className = "sr-only";
        caption.textContent = firstDesc.textContent;
        return [img, caption];
      }
      return [img];
    }

    async function makeMermaidError(text) {
      let errorMessage = "";
      try {
        await mermaid.parse(text);
      } catch (err) {
        errorMessage = `${err}`;
      }

      const result = document.createElement("details");
      result.className = 'jp-RenderedMermaid-Details';
      const summary = document.createElement("summary");
      summary.className = 'jp-RenderedMermaid-Summary';
      const pre = document.createElement("pre");
      const code = document.createElement("code");
      code.innerText = text;
      pre.appendChild(code);
      summary.appendChild(pre);
      result.appendChild(summary);

      const warning = document.createElement("pre");
      warning.innerText = errorMessage;
      result.appendChild(warning);
      return [result];
    }

    async function renderOneMarmaid(src) {
      const id = `jp-mermaid-${_nextMermaidId++}`;
      const parent = src.parentNode;
      let raw = src.textContent.trim();
      const el = document.createElement("div");
      el.style.visibility = "hidden";
      document.body.appendChild(el);
      let results = null;
      let output = null;
      try {
        let { svg } = await mermaid.render(id, raw, el);
        svg = cleanMermaidSvg(svg);
        results = makeMermaidImage(svg);
        output = document.createElement("figure");
        results.map(output.appendChild, output);
      } catch (err) {
        parent.classList.add("jp-mod-warning");
        results = await makeMermaidError(raw);
        output = results[0];
      } finally {
        el.remove();
      }
      parent.classList.add("jp-RenderedMermaid");
      parent.appendChild(output);
    }


    /**
     * Post-process to ensure mermaid diagrams contain only valid SVG and XHTML.
     */
    function cleanMermaidSvg(svg) {
      return svg.replace(RE_VOID_ELEMENT, replaceVoidElement);
    }


    /**
     * A regular expression for all void elements, which may include attributes and
     * a slash.
     *
     * @see https://developer.mozilla.org/en-US/docs/Glossary/Void_element
     *
     * Of these, only `<br>` is generated by Mermaid in place of `\n`,
     * but _any_ "malformed" tag will break the SVG rendering entirely.
     */
    const RE_VOID_ELEMENT =
      /<\s*(area|base|br|col|embed|hr|img|input|link|meta|param|source|track|wbr)\s*([^>]*?)\s*>/gi;

    /**
     * Ensure a void element is closed with a slash, preserving any attributes.
     */
    function replaceVoidElement(match, tag, rest) {
      rest = rest.trim();
      if (!rest.endsWith('/')) {
        rest = `${rest} /`;
      }
      return `<${tag} ${rest}>`;
    }

    void Promise.all([...diagrams].map(renderOneMarmaid));
  });
</script>
<style>
  .jp-Mermaid:not(.jp-RenderedMermaid) {
    display: none;
  }

  .jp-RenderedMermaid {
    overflow: auto;
    display: flex;
  }

  .jp-RenderedMermaid.jp-mod-warning {
    width: auto;
    padding: 0.5em;
    margin-top: 0.5em;
    border: var(--jp-border-width) solid var(--jp-warn-color2);
    border-radius: var(--jp-border-radius);
    color: var(--jp-ui-font-color1);
    font-size: var(--jp-ui-font-size1);
    white-space: pre-wrap;
    word-wrap: break-word;
  }

  .jp-RenderedMermaid figure {
    margin: 0;
    overflow: auto;
    max-width: 100%;
  }

  .jp-RenderedMermaid img {
    max-width: 100%;
  }

  .jp-RenderedMermaid-Details > pre {
    margin-top: 1em;
  }

  .jp-RenderedMermaid-Summary {
    color: var(--jp-warn-color2);
  }

  .jp-RenderedMermaid:not(.jp-mod-warning) pre {
    display: none;
  }

  .jp-RenderedMermaid-Summary > pre {
    display: inline-block;
    white-space: normal;
  }
</style>
<!-- End of mermaid configuration --></head>
<body class="jp-Notebook" data-jp-theme-light="true" data-jp-theme-name="JupyterLab Light">
<main><div class="jp-Cell jp-CodeCell jp-Notebook-cell jp-mod-noOutputs">
<div class="jp-Cell-inputWrapper" tabindex="0">
<div class="jp-Collapser jp-InputCollapser jp-Cell-inputCollapser">
</div>
<div class="jp-InputArea jp-Cell-inputArea">
<div class="jp-InputPrompt jp-InputArea-prompt">In [ ]:</div>
<div class="jp-CodeMirrorEditor jp-Editor jp-InputArea-editor" data-type="inline">
<div class="cm-editor cm-s-jupyter">
<div class="highlight hl-ipython3"><pre><span></span><span class="kn">import</span><span class="w"> </span><span class="nn">pandas</span><span class="w"> </span><span class="k">as</span><span class="w"> </span><span class="nn">pd</span>
<span class="kn">import</span><span class="w"> </span><span class="nn">matplotlib.pyplot</span><span class="w"> </span><span class="k">as</span><span class="w"> </span><span class="nn">plt</span>
<span class="kn">from</span><span class="w"> </span><span class="nn">sklearn.cluster</span><span class="w"> </span><span class="kn">import</span> <span class="n">KMeans</span>
<span class="kn">from</span><span class="w"> </span><span class="nn">sklearn.preprocessing</span><span class="w"> </span><span class="kn">import</span> <span class="n">StandardScaler</span>

<span class="c1"># Agar grafik muncul langsung di notebook</span>
<span class="o">%</span><span class="k">matplotlib</span> inline
<span class="kn">import</span><span class="w"> </span><span class="nn">warnings</span>
<span class="n">warnings</span><span class="o">.</span><span class="n">filterwarnings</span><span class="p">(</span><span class="s1">'ignore'</span><span class="p">)</span> <span class="c1"># Mengabaikan peringatan agar tampilan bersih</span>
</pre></div>
</div>
</div>
</div>
</div>
</div><div class="jp-Cell jp-CodeCell jp-Notebook-cell">
<div class="jp-Cell-inputWrapper" tabindex="0">
<div class="jp-Collapser jp-InputCollapser jp-Cell-inputCollapser">
</div>
<div class="jp-InputArea jp-Cell-inputArea">
<div class="jp-InputPrompt jp-InputArea-prompt">In [16]:</div>
<div class="jp-CodeMirrorEditor jp-Editor jp-InputArea-editor" data-type="inline">
<div class="cm-editor cm-s-jupyter">
<div class="highlight hl-ipython3"><pre><span></span><span class="n">df</span> <span class="o">=</span> <span class="n">pd</span><span class="o">.</span><span class="n">read_csv</span><span class="p">(</span><span class="s1">'/kaggle/input/shopping-mall-customer-segmentation-data/Shopping Mall Customer Segmentation Data .csv'</span><span class="p">)</span>
<span class="n">df</span> <span class="o">=</span> <span class="n">df</span><span class="o">.</span><span class="n">drop</span><span class="p">(</span><span class="n">columns</span><span class="o">=</span><span class="s2">"Customer ID"</span><span class="p">)</span>


<span class="c1"># Menampilkan 5 baris pertama</span>
<span class="nb">print</span><span class="p">(</span><span class="s2">"Data Awal:"</span><span class="p">)</span>
<span class="n">display</span><span class="p">(</span><span class="n">df</span><span class="o">.</span><span class="n">head</span><span class="p">())</span>


<span class="c1"># Cek info data</span>
<span class="nb">print</span><span class="p">(</span><span class="s2">"</span><span class="se">\n</span><span class="s2">Info Data:"</span><span class="p">)</span>
<span class="n">df</span><span class="o">.</span><span class="n">info</span><span class="p">()</span>
</pre></div>
</div>
</div>
</div>
</div>
<div class="jp-Cell-outputWrapper">
<div class="jp-Collapser jp-OutputCollapser jp-Cell-outputCollapser">
</div>
<div class="jp-OutputArea jp-Cell-outputArea">
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedText jp-OutputArea-output" data-mime-type="text/plain" tabindex="0">
<pre>Data Awal:
</pre>
</div>
</div>
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedHTMLCommon jp-RenderedHTML jp-OutputArea-output" data-mime-type="text/html" tabindex="0">
<div>
<style scoped="">
    .dataframe tbody tr th:only-of-type {
        vertical-align: middle;
    }

    .dataframe tbody tr th {
        vertical-align: top;
    }

    .dataframe thead th {
        text-align: right;
    }
</style>
<table border="1" class="dataframe">
<thead>
<tr style="text-align: right;">
<th></th>
<th>Age</th>
<th>Gender</th>
<th>Annual Income</th>
<th>Spending Score</th>
</tr>
</thead>
<tbody>
<tr>
<th>0</th>
<td>30</td>
<td>Male</td>
<td>151479</td>
<td>89</td>
</tr>
<tr>
<th>1</th>
<td>58</td>
<td>Female</td>
<td>185088</td>
<td>95</td>
</tr>
<tr>
<th>2</th>
<td>62</td>
<td>Female</td>
<td>70912</td>
<td>76</td>
</tr>
<tr>
<th>3</th>
<td>23</td>
<td>Male</td>
<td>55460</td>
<td>57</td>
</tr>
<tr>
<th>4</th>
<td>24</td>
<td>Male</td>
<td>153752</td>
<td>76</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedText jp-OutputArea-output" data-mime-type="text/plain" tabindex="0">
<pre>
Info Data:
&lt;class 'pandas.core.frame.DataFrame'&gt;
RangeIndex: 15079 entries, 0 to 15078
Data columns (total 4 columns):
 #   Column          Non-Null Count  Dtype 
---  ------          --------------  ----- 
 0   Age             15079 non-null  int64 
 1   Gender          15079 non-null  object
 2   Annual Income   15079 non-null  int64 
 3   Spending Score  15079 non-null  int64 
dtypes: int64(3), object(1)
memory usage: 471.3+ KB
</pre>
</div>
</div>
</div>
</div>
</div><div class="jp-Cell jp-CodeCell jp-Notebook-cell">
<div class="jp-Cell-inputWrapper" tabindex="0">
<div class="jp-Collapser jp-InputCollapser jp-Cell-inputCollapser">
</div>
<div class="jp-InputArea jp-Cell-inputArea">
<div class="jp-InputPrompt jp-InputArea-prompt">In [17]:</div>
<div class="jp-CodeMirrorEditor jp-Editor jp-InputArea-editor" data-type="inline">
<div class="cm-editor cm-s-jupyter">
<div class="highlight hl-ipython3"><pre><span></span><span class="c1"># 1. Memilih Fitur</span>
<span class="n">X</span> <span class="o">=</span> <span class="n">df</span><span class="p">[[</span><span class="s1">'Annual Income'</span><span class="p">,</span> <span class="s1">'Spending Score'</span><span class="p">]]</span>

<span class="c1"># 2. Scaling Data (Sangat Penting!)</span>
<span class="c1"># Kita pakai StandardScaler agar mean=0 dan standar deviasi=1</span>
<span class="n">scaler</span> <span class="o">=</span> <span class="n">StandardScaler</span><span class="p">()</span>
<span class="n">X_scaled</span> <span class="o">=</span> <span class="n">scaler</span><span class="o">.</span><span class="n">fit_transform</span><span class="p">(</span><span class="n">X</span><span class="p">)</span>

<span class="c1"># Tampilkan sedikit hasil scaling</span>
<span class="nb">print</span><span class="p">(</span><span class="s2">"Data setelah di-scaling (5 baris pertama):</span><span class="se">\n</span><span class="s2">"</span><span class="p">,</span> <span class="n">X_scaled</span><span class="p">[:</span><span class="mi">5</span><span class="p">])</span>
</pre></div>
</div>
</div>
</div>
</div>
<div class="jp-Cell-outputWrapper">
<div class="jp-Collapser jp-OutputCollapser jp-Cell-outputCollapser">
</div>
<div class="jp-OutputArea jp-Cell-outputArea">
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedText jp-OutputArea-output" data-mime-type="text/plain" tabindex="0">
<pre>Data setelah di-scaling (5 baris pertama):
 [[ 0.79881267  1.33705873]
 [ 1.44207552  1.54592857]
 [-0.74320756  0.88450743]
 [-1.03895267  0.2230863 ]
 [ 0.84231698  0.88450743]]
</pre>
</div>
</div>
</div>
</div>
</div><div class="jp-Cell jp-CodeCell jp-Notebook-cell">
<div class="jp-Cell-inputWrapper" tabindex="0">
<div class="jp-Collapser jp-InputCollapser jp-Cell-inputCollapser">
</div>
<div class="jp-InputArea jp-Cell-inputArea">
<div class="jp-InputPrompt jp-InputArea-prompt">In [18]:</div>
<div class="jp-CodeMirrorEditor jp-Editor jp-InputArea-editor" data-type="inline">
<div class="cm-editor cm-s-jupyter">
<div class="highlight hl-ipython3"><pre><span></span><span class="n">wcss</span> <span class="o">=</span> <span class="p">[]</span> <span class="c1"># Within-Cluster Sum of Square (tingkat error)</span>

<span class="c1"># Coba jumlah cluster dari 1 sampai 10</span>
<span class="k">for</span> <span class="n">i</span> <span class="ow">in</span> <span class="nb">range</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span> <span class="mi">11</span><span class="p">):</span>
    <span class="n">kmeans</span> <span class="o">=</span> <span class="n">KMeans</span><span class="p">(</span><span class="n">n_clusters</span><span class="o">=</span><span class="n">i</span><span class="p">,</span> <span class="n">init</span><span class="o">=</span><span class="s1">'k-means++'</span><span class="p">,</span> <span class="n">random_state</span><span class="o">=</span><span class="mi">42</span><span class="p">)</span>
    <span class="n">kmeans</span><span class="o">.</span><span class="n">fit</span><span class="p">(</span><span class="n">X_scaled</span><span class="p">)</span>
    <span class="n">wcss</span><span class="o">.</span><span class="n">append</span><span class="p">(</span><span class="n">kmeans</span><span class="o">.</span><span class="n">inertia_</span><span class="p">)</span>

<span class="c1"># Plot Grafik Elbow</span>
<span class="n">plt</span><span class="o">.</span><span class="n">figure</span><span class="p">(</span><span class="n">figsize</span><span class="o">=</span><span class="p">(</span><span class="mi">8</span><span class="p">,</span> <span class="mi">5</span><span class="p">))</span>
<span class="n">plt</span><span class="o">.</span><span class="n">plot</span><span class="p">(</span><span class="nb">range</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span> <span class="mi">11</span><span class="p">),</span> <span class="n">wcss</span><span class="p">,</span> <span class="n">marker</span><span class="o">=</span><span class="s1">'o'</span><span class="p">,</span> <span class="n">linestyle</span><span class="o">=</span><span class="s1">'--'</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">title</span><span class="p">(</span><span class="s1">'Elbow Method untuk Menentukan K Optimal'</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">xlabel</span><span class="p">(</span><span class="s1">'Jumlah Cluster (K)'</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">ylabel</span><span class="p">(</span><span class="s1">'WCSS (Error)'</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">grid</span><span class="p">(</span><span class="kc">True</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">show</span><span class="p">()</span>

<span class="nb">print</span><span class="p">(</span><span class="s2">"Lihat grafik di atas. Titik di mana penurunan mulai melandai (membentuk siku) adalah K optimal."</span><span class="p">)</span>
<span class="nb">print</span><span class="p">(</span><span class="s2">"Untuk data sampel kecil ini, mungkin K=3 atau K=4 terlihat masuk akal. Mari kita coba K=4."</span><span class="p">)</span>
</pre></div>
</div>
</div>
</div>
</div>
<div class="jp-Cell-outputWrapper">
<div class="jp-Collapser jp-OutputCollapser jp-Cell-outputCollapser">
</div>
<div class="jp-OutputArea jp-Cell-outputArea">
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedImage jp-OutputArea-output" tabindex="0">
<img alt="No description has been provided for this image" class="" src="data:image/png;base64,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"/>
</div>
</div>
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedText jp-OutputArea-output" data-mime-type="text/plain" tabindex="0">
<pre>Lihat grafik di atas. Titik di mana penurunan mulai melandai (membentuk siku) adalah K optimal.
Untuk data sampel kecil ini, mungkin K=3 atau K=4 terlihat masuk akal. Mari kita coba K=4.
</pre>
</div>
</div>
</div>
</div>
</div><div class="jp-Cell jp-CodeCell jp-Notebook-cell">
<div class="jp-Cell-inputWrapper" tabindex="0">
<div class="jp-Collapser jp-InputCollapser jp-Cell-inputCollapser">
</div>
<div class="jp-InputArea jp-Cell-inputArea">
<div class="jp-InputPrompt jp-InputArea-prompt">In [19]:</div>
<div class="jp-CodeMirrorEditor jp-Editor jp-InputArea-editor" data-type="inline">
<div class="cm-editor cm-s-jupyter">
<div class="highlight hl-ipython3"><pre><span></span><span class="c1"># Tentukan K pilihan Anda di sini</span>
<span class="n">K_OPTIMAL</span> <span class="o">=</span> <span class="mi">4</span>

<span class="c1"># Jalankan K-Means final</span>
<span class="n">kmeans_final</span> <span class="o">=</span> <span class="n">KMeans</span><span class="p">(</span><span class="n">n_clusters</span><span class="o">=</span><span class="n">K_OPTIMAL</span><span class="p">,</span> <span class="n">init</span><span class="o">=</span><span class="s1">'k-means++'</span><span class="p">,</span> <span class="n">random_state</span><span class="o">=</span><span class="mi">42</span><span class="p">)</span>
<span class="n">y_kmeans</span> <span class="o">=</span> <span class="n">kmeans_final</span><span class="o">.</span><span class="n">fit_predict</span><span class="p">(</span><span class="n">X_scaled</span><span class="p">)</span>

<span class="c1"># Masukkan hasil label kembali ke DataFrame asli</span>
<span class="n">df</span><span class="p">[</span><span class="s1">'Cluster_Label'</span><span class="p">]</span> <span class="o">=</span> <span class="n">y_kmeans</span>

<span class="nb">print</span><span class="p">(</span><span class="s2">"Data dengan label cluster:"</span><span class="p">)</span>
<span class="n">display</span><span class="p">(</span><span class="n">df</span><span class="o">.</span><span class="n">head</span><span class="p">())</span>
</pre></div>
</div>
</div>
</div>
</div>
<div class="jp-Cell-outputWrapper">
<div class="jp-Collapser jp-OutputCollapser jp-Cell-outputCollapser">
</div>
<div class="jp-OutputArea jp-Cell-outputArea">
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedText jp-OutputArea-output" data-mime-type="text/plain" tabindex="0">
<pre>Data dengan label cluster:
</pre>
</div>
</div>
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedHTMLCommon jp-RenderedHTML jp-OutputArea-output" data-mime-type="text/html" tabindex="0">
<div>
<style scoped="">
    .dataframe tbody tr th:only-of-type {
        vertical-align: middle;
    }

    .dataframe tbody tr th {
        vertical-align: top;
    }

    .dataframe thead th {
        text-align: right;
    }
</style>
<table border="1" class="dataframe">
<thead>
<tr style="text-align: right;">
<th></th>
<th>Age</th>
<th>Gender</th>
<th>Annual Income</th>
<th>Spending Score</th>
<th>Cluster_Label</th>
</tr>
</thead>
<tbody>
<tr>
<th>0</th>
<td>30</td>
<td>Male</td>
<td>151479</td>
<td>89</td>
<td>0</td>
</tr>
<tr>
<th>1</th>
<td>58</td>
<td>Female</td>
<td>185088</td>
<td>95</td>
<td>0</td>
</tr>
<tr>
<th>2</th>
<td>62</td>
<td>Female</td>
<td>70912</td>
<td>76</td>
<td>2</td>
</tr>
<tr>
<th>3</th>
<td>23</td>
<td>Male</td>
<td>55460</td>
<td>57</td>
<td>2</td>
</tr>
<tr>
<th>4</th>
<td>24</td>
<td>Male</td>
<td>153752</td>
<td>76</td>
<td>0</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div><div class="jp-Cell jp-CodeCell jp-Notebook-cell">
<div class="jp-Cell-inputWrapper" tabindex="0">
<div class="jp-Collapser jp-InputCollapser jp-Cell-inputCollapser">
</div>
<div class="jp-InputArea jp-Cell-inputArea">
<div class="jp-InputPrompt jp-InputArea-prompt">In [20]:</div>
<div class="jp-CodeMirrorEditor jp-Editor jp-InputArea-editor" data-type="inline">
<div class="cm-editor cm-s-jupyter">
<div class="highlight hl-ipython3"><pre><span></span><span class="n">plt</span><span class="o">.</span><span class="n">figure</span><span class="p">(</span><span class="n">figsize</span><span class="o">=</span><span class="p">(</span><span class="mi">10</span><span class="p">,</span> <span class="mi">6</span><span class="p">))</span>

<span class="c1"># Scatter plot untuk setiap cluster</span>
<span class="c1"># Kita loop sebanyak K_OPTIMAL untuk membuat warna berbeda tiap cluster</span>
<span class="n">colors</span> <span class="o">=</span> <span class="p">[</span><span class="s1">'red'</span><span class="p">,</span> <span class="s1">'blue'</span><span class="p">,</span> <span class="s1">'green'</span><span class="p">,</span> <span class="s1">'cyan'</span><span class="p">,</span> <span class="s1">'magenta'</span><span class="p">]</span> <span class="c1"># Siapkan warna cukup banyak</span>

<span class="k">for</span> <span class="n">i</span> <span class="ow">in</span> <span class="nb">range</span><span class="p">(</span><span class="n">K_OPTIMAL</span><span class="p">):</span>
    <span class="n">plt</span><span class="o">.</span><span class="n">scatter</span><span class="p">(</span><span class="n">X_scaled</span><span class="p">[</span><span class="n">y_kmeans</span> <span class="o">==</span> <span class="n">i</span><span class="p">,</span> <span class="mi">0</span><span class="p">],</span> <span class="n">X_scaled</span><span class="p">[</span><span class="n">y_kmeans</span> <span class="o">==</span> <span class="n">i</span><span class="p">,</span> <span class="mi">1</span><span class="p">],</span>
                <span class="n">s</span><span class="o">=</span><span class="mi">100</span><span class="p">,</span> <span class="n">c</span><span class="o">=</span><span class="n">colors</span><span class="p">[</span><span class="n">i</span><span class="p">],</span> <span class="n">label</span><span class="o">=</span><span class="sa">f</span><span class="s1">'Cluster </span><span class="si">{</span><span class="n">i</span><span class="si">}</span><span class="s1">'</span><span class="p">)</span>

<span class="c1"># Plot centroid (titik pusat cluster)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">scatter</span><span class="p">(</span><span class="n">kmeans_final</span><span class="o">.</span><span class="n">cluster_centers_</span><span class="p">[:,</span> <span class="mi">0</span><span class="p">],</span> <span class="n">kmeans_final</span><span class="o">.</span><span class="n">cluster_centers_</span><span class="p">[:,</span> <span class="mi">1</span><span class="p">],</span>
            <span class="n">s</span><span class="o">=</span><span class="mi">300</span><span class="p">,</span> <span class="n">c</span><span class="o">=</span><span class="s1">'yellow'</span><span class="p">,</span> <span class="n">label</span><span class="o">=</span><span class="s1">'Centroids'</span><span class="p">,</span> <span class="n">marker</span><span class="o">=</span><span class="s1">'*'</span><span class="p">)</span>

<span class="n">plt</span><span class="o">.</span><span class="n">title</span><span class="p">(</span><span class="s1">'Hasil Clustering Pelanggan'</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">xlabel</span><span class="p">(</span><span class="s1">'Annual Income (Scaled)'</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">ylabel</span><span class="p">(</span><span class="s1">'Spending Score (Scaled)'</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">legend</span><span class="p">()</span>
<span class="n">plt</span><span class="o">.</span><span class="n">grid</span><span class="p">(</span><span class="kc">True</span><span class="p">)</span>
<span class="n">plt</span><span class="o">.</span><span class="n">show</span><span class="p">()</span>
</pre></div>
</div>
</div>
</div>
</div>
<div class="jp-Cell-outputWrapper">
<div class="jp-Collapser jp-OutputCollapser jp-Cell-outputCollapser">
</div>
<div class="jp-OutputArea jp-Cell-outputArea">
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedImage jp-OutputArea-output" tabindex="0">
<img alt="No description has been provided for this image" class="" src="data:image/png;base64,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+IG7774bo9HI0aNH+eqrr4iNjbX5vB/AP/7xD6ZPn87TTz9Nx44d+e2331ixYgURERHFyuLp6cnUqVMZOXIknTt35vHHH+f06dMsXbq0wPNXzz33HAsWLKBfv36MHj2a6tWrs2LFCssA2bnzNmzYkMjISMaPH8/58+cJDAxkzZo18oyVEKLckCJLCCF0rkGDBqxevZrXXnuN8ePHU61aNYYPH05YWJjVQMP3338/e/fu5csvv+Ty5ctUqlSJtm3bsmLFCqc6dyjMc889R5s2bZg1axbLly/n6tWr+Pv7c9ddd7FkyRKefPJJu8uGhoaydu1axo0bx4QJE6hXrx5vvfUWx48ftyqyevfuzenTp/nss8+4du0alStX5v7772fatGlUqlQJAA8PD5YtW8bLL7/MsGHDyM7OZsmSJdSrV49OnTqxa9cu3njjDRYsWEBycjLVqlWjXbt2PPfccy45DoVp1aoVmzZtYvz48bz++uuEh4czffp0jhw5wtGjR12yDYPBwLp165g9ezbLly9n7dq1+Pr6EhERwejRo7njjjvsLvvKK6+QkpLCypUrWbVqFXfddRcbNmxg0qRJxc4zYsQIVFVl1qxZjB8/nubNm/Ptt98yatQoSwEF5ufhtm3bxsiRI5k7dy7+/v4MHDiQjh07EhMTY5nXw8OD9evXM2rUKN566y28vb155JFHGDFiBM2bNy92TiGEKCuKWppPrgohhBACgD59+vDHH39YekC83ZlMJsLCwnj00UdtNmvMa86cOYwdO5Zz585Rs2bNMkoohBClR57JEkIIIVwsLS3N6ufjx4+zceNGOnXqpE2gUpaenl7gOa/ly5eTkJBQYJ/zH5v09HQWL15M/fr1pcASQtw2pLmgEEII4WIRERE89dRTREREcObMGT766CM8PT2ZMGGC1tFKxe7duxk7diyPPfYYoaGhHDx4kH//+980adKExx57zGreRx99lNq1a9OiRQuSkpL4z3/+w9GjR1mxYoVG6YUQwvWkyBJCCCFc7MEHH+SLL77g0qVLeHl50aFDB2bOnEn9+vW1jlYq6tatS3h4OPPmzSMhIYGQkBAGDhzI22+/jaenp9W80dHRfPrpp6xYsQKj0Ujjxo358ssv6du3r0bphRDC9eSZLCGEEEIIIYRwIXkmSwghhBBCCCFcSIosIYQQQgghhHAheSarCCaT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kWUhdUgsImKhecCd6BwtERFLZAG2HvylIstC6pBYRMRCscCbTocQEZHy8pwO4EOY0wHkROqQWETEQtcCMejrSRERizR1OoAPequwkDokFhGx0D2A9ssiItZIAeKdDuGDiiwLlXVILCIiFklCRZaIiEUuxt7dsoosS6WlQXS00ylERIRYpwOIiIg3L2FvX1kqsiwVFwc33OB0ChER4VqnA4iIiDdHsLevLBVZljIGVqxwOoWIiHCb0wFERMQXW/vKUpFlqexsyMpyOoWISJBLADo6HUJERLwx2NtXloosS6mvLBERC6hLDRER69nYV5aKLEuprywREQvoCy8REevZ2FeWiixLJSS4byIi4qBsYLvTIURExBsX9vaVpSJLRESkKvOcDiAiIr5MwM6+slRkWSo7230TERGHvVJ6X+xoChERKccFxAC29nikIstSuvCFiIglckvvbbxGsIhIkDK4+8iKcziHLyqyLKULX4iIWOZVpwOIiEh53zsdoAoqsiyVkAApKeCy8SBTEZFgclHp/bXo1ywREYvY2hExqMiylssF48c7nUJEJMhdArxR+ncIdp5dLSISpGztiBhUZFktLQ2io51OISISpJoBb6LCSkTEYv9zOoAPKrIsFhcHPXs6nUJEJEil4b50VajTQURExJdlTgfwIWCKrOnTpzNw4EBiYmKIi4vza5wxY8bgcrkq3IYMGVK/QetQSQn8979OpxARCVI6ZFtExHovYOd5WWFOB/BXYWEhV111FQMGDOCFF17we7whQ4bw4osvev6PjIysj3j1YutWOH7c6RQiIkEoAehU+rf6xxIRsVbZeVkJTgepJGCKrGnTpgGQnp5eo/EiIyNJSkqqh0T1b/t2pxOIiAQpdaMhIhIw8lCR1eA+/vhjWrZsSfPmzbnooot47LHHSEjw3QzHjh3j2LFjnv9zc929UBYVFVFUVFTvecv74ovAv/BFdHRRhXuxg9rFTmoXixwHSpshunTfH93A7wFSPbWNndQudmrM7RKNZ5dd7/ytB1zGGBsPY/QpPT2diRMncvjw4WqHffXVV4mJiaFDhw5kZWXxhz/8gSZNmpCRkUFoqPczmR955BHPr2blvfLKK8TExJxsfBERERERCVBHjhzh2muvJScnh9jYWJ/DOVpkTZo0iVmzZlU5zObNm+natavn/5oUWZVt376dlJQUVq5c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a9LEffXF4mL3fWys93VZVbvk5sLx41WP7y1/5Vzl16uv/3Nz4dixIrZscbdLy5bhfmX1lqf8cN7aqKa/ONRkvpXbvnlz2L696u2xpjm8tQtUn9HXclS1vpo3hx9/LGLNmnfp3Nn9enG5/N+u/V13vsatyWupuuWo/Poum05124uvdVvdspXti/bvd/86l5jobq/K06/t8pS1S9nrBRccBPJwX1o4Hu/fWBv8G65s2GygtAloAySU/p0N7AJ24z49LAk4A/e31vml024OHAJygeO4D+0rxv1rVdnlj8uG9ZajGFgH7CydVkfch+lUlbmq5S3rgSS/0t/VrQdv0yq/fJWnHV1UxJp332Xo0KGEhYf7HKf8fKua9imlf/8AtMJ9ZbPyu5HK7XRq6TTzgKLSTC7c7Rdfaf6Vl8EA31eajrd15G07ghPXdR7utg8DYr0MV9U6qUrZ/Mu2rfLTrzxu2bCHi4r47t13uXToUCLCwys87239Vd6O/clXAmQBB3C3VUfgcBXjelsOX6+N6l67vl6vvtaHt7bLwd3B7o+4t7vupePvKX0utnSc8HI5y7azvNLlaAa09TFvb6/pJqWvl0uHDiUvPJw83L9Y7sC9jyn/2q/cFpX3Md62g5rs82ozvC38rQ1UZFXDxiIrkJQVWUOHDiW83I5WnKV2sZPaxU5qF3upbeykdrGT2qVu+FsbOH34poiIiIiISKOiIktERERERKQOqcgSERERERGpQyqyRERERERE6pCKLBERERERkTqkIktERERERKQOqcgSERERERGpQyqyRERERERE6pCKLBERERERkTqkIktERERERKQOhTkdwHbGGAByc3MdThKYioqKOHLkCLm5uYSHhzsdR0qpXeykdrGT2sVeahs7qV3spHapG2U1QVmN4IuKrGrk5eUB0KZNG4eTiIiIiIiIDfLy8mjWrJnP512mujIsyJWUlLB3716aNm2Ky+VyOk7Ayc3NpU2bNuzZs4fY2Fin40gptYud1C52UrvYS21jJ7WLndQudcMYQ15eHq1btyYkxPeZV/olqxohISGceuqpTscIeLGxsXpBW0jtYie1i53ULvZS29hJ7WIntcvJq+oXrDK68IWIiIiIiEgdUpElIiIiIiJSh1RkSb2KjIxk6tSpREZGOh1FylG72EntYie1i73UNnZSu9hJ7dKwdOELERERERGROqRfskREREREROqQiiwREREREZE6pCJLRERERESkDqnIEhERERERqUMqsqROTZ8+nYEDBxITE0NcXJxf44wZMwaXy1XhNmTIkPoNGoRq0zbGGKZMmUJycjLR0dEMHjyYrVu31m/QIHPw4EF+//vfExsbS1xcHGPHjiU/P7/KcS688MITXjO33357AyVunJ555hnat29PVFQU/fr147///W+Vw7/xxht07dqVqKgozjzzTN59990GShp8atI26enpJ7w2oqKiGjBtcPj000+5/PLLad26NS6XiyVLllQ7zscff0zv3r2JjIykU6dOpKen13vOYFPTdvn4449PeL24XC7279/fMIEbORVZUqcKCwu56qqrGDduXI3GGzJkCPv27fPc/v3vf9dTwuBVm7Z54oknmD17NnPnzmXt2rWccsoppKamcvTo0XpMGlx+//vfs3HjRlasWMHSpUv59NNPufXWW6sd75ZbbqnwmnniiScaIG3j9Nprr3HvvfcydepU1q9fT48ePUhNTeWHH37wOvwXX3zB6NGjGTt2LF9//TXDhw9n+PDhfPfddw2cvPGradsAxMbGVnht7Nq1qwETB4eff/6ZHj168Mwzz/g1/I4dO7jsssv4zW9+Q2ZmJhMnTuTmm29m+fLl9Zw0uNS0Xcps2bKlwmumZcuW9ZQwyBiRevDiiy+aZs2a+TVsWlqaueKKK+o1j/zC37YpKSkxSUlJ5i9/+YvnscOHD5vIyEjz73//ux4TBo9NmzYZwHz55Zeex9577z3jcrnM//73P5/jXXDBBebuu+9ugITBoW/fvubOO+/0/F9cXGxat25tZsyY4XX4UaNGmcsuu6zCY/369TO33XZbveYMRjVtm5q890jdAMzixYurHObBBx803bt3r/DY1VdfbVJTU+sxWXDzp10++ugjA5hDhw41SKZgo1+yxAoff/wxLVu2pEuXLowbN47s7GynIwW9HTt2sH//fgYPHux5rFmzZvTr14+MjAwHkzUeGRkZxMXFcfbZZ3seGzx4MCEhIaxdu7bKcV9++WUSExM544wzmDx5MkeOHKnvuI1SYWEh69atq7Cdh4SEMHjwYJ/beUZGRoXhAVJTU/W6qGO1aRuA/Px82rVrR5s2bbjiiivYuHFjQ8SVKug1Y7eePXuSnJzMxRdfzOrVq52O02iEOR1AZMiQIYwY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jjtOqljYuXMnLpeLRYsW8Zvf/IaYmBh69OhBRkZGheFWr17NhRdeSExMDM2bNyc1NZVDhw4BcOzYMSZMmEDLli2JiorivPPO48svvzxh/SxfvpxevXoRHR3NRRddxA8//MB7773H6aefTmxsLNdeey1HjhzxjFdSUsKMGTPo0KED0dHR9OjRg//85z9VLs/rr79Ojx49+NWvfuV57O2332bUqFGMHTuWTp060b17d0aPHs306dMrjDt//ny6d+9OZGQkycnJ3HXXXZ7narPe33rrLXr37k1UVBQdO3Zk2rRpHD9+3PP81q1b+fWvf01UVBTdunVjxYoVJ0yje/futG7dmsWLF1c5LxGRxkJFlohIkHj99dfp2rUrXbp04brrrmP+/PkYY04Y7uGHH+Zvf/sbX331FWFhYdx0000Vns/KymLJkiUsXbqUpUuX8sknnzBz5swaZQkJCWH27Nls3LiRBQsW8OGHH/Lggw+e1PKVZb///vvJzMykc+fOjB492lMQZGZmMmjQILp160ZGRgaff/45l19+OcXFxQA8+OCDvPnmmyxYsID169fTqVMnUlNTT/j15ZFHHuEf//gHX3zxBXv27GHUqFE8/fTTvPLKKyxbtowPPviAOXPmeIafMWMGCxcuZO7cuWzcuJF77rmH6667jk8++cTncnz22WecffbZFR5LSkpizZo17Nq1y+d4zz33HHfeeSe33norGzZs4O2336ZTp06e52u63j/77DNuuOEG7r77bjZt2sS8efNIT0/3FHYlJSWMGDGCiIgI1q5dy9y5c3nooYe8Tqtv37589tlnPuclItKoGBERCQoDBw40Tz/9tDHGmKKiIpOYmGg++ugjz/MfffSRAczKlSs9jy1btswApqCgwBhjzNSpU01MTIzJzc31DPPAAw+Yfv36ef5v166deeqppyrMu0ePHmbq1Kk+s73xxhsmISHB8/+LL75omjVrVuXyAGbx4sXGGGN27NhhAPOvf/3L8/zGjRsNYDZv3myMMWb06NHm3HPP9Tqt/Px8Ex4ebl5++WXPY4WFhaZ169bmiSeeMMZ4Xz8zZswwgMnKyvI8dtttt5nU1FRjjDFHjx41MTEx5osvvqgwv7Fjx5rRo0f7XLYePXqYRx99tMJje/fuNf379zeA6dy5s0lLSzOvvfaaKS4u9gzTunVr8/DDD/ucbmXVrfdBgwaZxx9/vMI4L730kklOTjbGGLN8+XITFhZm/ve//3mef++99yq0TZl77rnHXHjhhX5nExEJZPolS0QkCGzZsoX//ve/jB49GoCwsDCuvvpqXnjhhROGPeusszx/JycnA/DDDz94Hmvfvn2FizEkJydXeN4fK1euZNCgQfzqV7+iadOmXH/99WRnZ1c4zK42qspe9kuWN1lZWRQVFXHuued6HgsPD6dv375s3rzZ5zxatWpFTEwMHTt2rPBY2Ty3bdvGkSNHuPjii2nSpInntnDhQrKysnwuR0FBAVFRURUeS05OJiMjgw0bNnD33Xdz/Phx0tLSGDJkCCUlJfzwww/s3bvX5zJCzdf7N998w6OPPloh+y233MK+ffs4cuQImzdvpk2bNrRu3dozzoABA7xOKzo6+qTbV0QkUIQ5HUBEROrfCy+8wPHjxyt8GDbGEBkZyT/+8Q+aNWvmeTw8PNzzt8vlAtyHhXl7vmyY8s+HhISccBhiUVGR5++dO3cybNgwxo0bx/Tp04mPj+fzzz9n7NixFBYWEhMTU+vlrCp7dHR0radb1TyqWh9l5zstW7aswvlVAJGRkT7nkZiY6DlXrLIzzjiDM844gzvuuIPbb7+d888/n08++eSEwwsrq816z8/PZ9q0aYwYMeKE5yoXgdU5ePAgLVq0qNE4IiKBSr9kiYg0csePH2fhwoX87W9/IzMz03P75ptvaN26Nf/+97/rdH4tWrRg3759nv9zc3PZsWOH5/9169ZRUlLC3/72N/r370/nzp0b5EqHZ511FqtWrfL6XEpKChEREaxevdrzWFFREV9++SXdunWr9Ty7detGZGQku3fvplOnThVubdq08Tler1692LRpk1/TB/j5559p2rQp7du397mMtVnvvXv3ZsuWLSdk79SpEyEhIZx++uns2bOnQnuvWbPG67S+++47evXqVe0yiYg0BvolS0SkkVu6dCmHDh1i7NixFX6xAhg5ciQvvPACt99+e53N76KLLiI9PZ3LL7+cuLg4pkyZQmhoqOf5Tp06UVRUxJw5c7j88stZvXo1c+fOrbP5+zJ58mTOPPNMzy9AERERfPTRR1x11VUkJiYybtw4HnjgAeLj42nbti1PPPEER44cYezYsbWeZ9OmTbn//vu55557KCkp4bzzziMnJ4fVq1cTGxtLWlqa1/FSU1O5+eabKS4u9qy7cePG0bp1ay666CJOPfVU9u3bx2OPPUaLFi08h+g98sgj3H777bRs2ZJLL72UvLw8Vq9ezfjx42u13qdMmcKwYcNo27Ytv/vd7wgJCeGbb77hu+++47HHHmPw4MF07tyZtLQ0/vKXv5Cbm8vDDz98wnSOHDnCunXrePzxx2u9LkVEAol+yRIRaeReeOEFBg8efEKBBe4i66uvvuLbb7+ts/lNnjyZCy64gGHDhnHZZZcxfPhwUlJSPM/36NGDJ598klmzZnHGGWfw8ssvN0iHup07d+aDDz7gm2++oW/fvgwYMIC33nqLsDD3940zZ85k5MiRXH/99fTu3Ztt27axfPlymjdvflLz/fOf/8yf/vQnZsyYwemnn86QIUNYtmwZHTp08DnOpZdeSlhYGCtXrvQ8NnjwYNasWcNVV11F586dGTlyJFFRUaxatYqEhAQA0tLSePrpp3n22Wfp3r07w4YNY+vWrUDt1ntqaipLly7lgw8+4JxzzqF///489dRTtGvXDnAfGrp48WIKCgro27cvN9988wmXlAf3ZeDbtm3L+eefX+P1JyISiFym8oHzIiIi4rhnnnmGt99+m+XLlzsd5aT179+fCRMmcO211zodRUSkQehwQREREQvddtttHD58mLy8vApXcww0P/30EyNGjPBc2VJEJBjolywREREREZE6pHOyRERERERE6pCKLBERERERkTqkIktERERERKQOqcgSERERERGpQyqyRERERERE6pCKLBERERERkTqkIktERERERKQOqcgSERERERGpQyqyRERERERE6tD/BxSxjw+HKEyHAAAAAElFTkSuQmCC"/>
</div>
</div>
</div>
</div>
</div><div class="jp-Cell jp-CodeCell jp-Notebook-cell">
<div class="jp-Cell-inputWrapper" tabindex="0">
<div class="jp-Collapser jp-InputCollapser jp-Cell-inputCollapser">
</div>
<div class="jp-InputArea jp-Cell-inputArea">
<div class="jp-InputPrompt jp-InputArea-prompt">In [ ]:</div>
<div class="jp-CodeMirrorEditor jp-Editor jp-InputArea-editor" data-type="inline">
<div class="cm-editor cm-s-jupyter">
<div class="highlight hl-ipython3"><pre><span></span><span class="c1"># Group by Cluster_Label dan hitung rata-rata fitur aslinya</span>
<span class="n">profil_cluster</span> <span class="o">=</span> <span class="n">df</span><span class="o">.</span><span class="n">groupby</span><span class="p">(</span><span class="s1">'Cluster_Label'</span><span class="p">)[[</span><span class="s1">'Annual Income'</span><span class="p">,</span> <span class="s1">'Spending Score'</span><span class="p">]]</span><span class="o">.</span><span class="n">mean</span><span class="p">()</span>
<span class="n">profil_cluster</span><span class="p">[</span><span class="s1">'Jumlah Pelanggan'</span><span class="p">]</span> <span class="o">=</span> <span class="n">df</span><span class="p">[</span><span class="s1">'Cluster_Label'</span><span class="p">]</span><span class="o">.</span><span class="n">value_counts</span><span class="p">()</span>

<span class="nb">print</span><span class="p">(</span><span class="s2">"Profil Tiap Cluster (Rata-rata):"</span><span class="p">)</span>
<span class="n">display</span><span class="p">(</span><span class="n">profil_cluster</span><span class="p">)</span>


<span class="c1"># Fungsi untuk mapping nama segmen bisnis</span>
<span class="k">def</span><span class="w"> </span><span class="nf">namai_cluster</span><span class="p">(</span><span class="n">label</span><span class="p">):</span>
    <span class="k">if</span> <span class="n">label</span> <span class="o">==</span> <span class="mi">0</span><span class="p">:</span>
        <span class="k">return</span> <span class="s2">"Sultan/Royal"</span>
    <span class="k">elif</span> <span class="n">label</span> <span class="o">==</span> <span class="mi">1</span><span class="p">:</span>
        <span class="k">return</span> <span class="s2">"Hemat"</span>
    <span class="k">elif</span> <span class="n">label</span> <span class="o">==</span> <span class="mi">2</span><span class="p">:</span>
        <span class="k">return</span> <span class="s2">"Target Utama"</span>
    <span class="k">elif</span> <span class="n">label</span> <span class="o">==</span> <span class="mi">3</span><span class="p">:</span>
        <span class="k">return</span> <span class="s2">"Penabung"</span>
    <span class="k">else</span><span class="p">:</span>
        <span class="k">return</span> <span class="s2">"Lainnya"</span>

<span class="n">df</span><span class="p">[</span><span class="s1">'Nama_Segmen'</span><span class="p">]</span> <span class="o">=</span> <span class="n">df</span><span class="p">[</span><span class="s1">'Cluster_Label'</span><span class="p">]</span><span class="o">.</span><span class="n">apply</span><span class="p">(</span><span class="n">namai_cluster</span><span class="p">)</span>

<span class="nb">print</span><span class="p">(</span><span class="s2">"</span><span class="se">\n</span><span class="s2">Hasil Akhir dengan Nama Segmen Bisnis:"</span><span class="p">)</span>
<span class="n">display</span><span class="p">(</span><span class="n">df</span><span class="p">[[</span><span class="s1">'Age'</span><span class="p">,</span> <span class="s1">'Annual Income'</span><span class="p">,</span> <span class="s1">'Spending Score'</span><span class="p">,</span> <span class="s1">'Nama_Segmen'</span><span class="p">]])</span>
</pre></div>
</div>
</div>
</div>
</div>
<div class="jp-Cell-outputWrapper">
<div class="jp-Collapser jp-OutputCollapser jp-Cell-outputCollapser">
</div>
<div class="jp-OutputArea jp-Cell-outputArea">
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedText jp-OutputArea-output" data-mime-type="text/plain" tabindex="0">
<pre>Profil Tiap Cluster (Rata-rata):
</pre>
</div>
</div>
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedHTMLCommon jp-RenderedHTML jp-OutputArea-output" data-mime-type="text/html" tabindex="0">
<div>
<style scoped="">
    .dataframe tbody tr th:only-of-type {
        vertical-align: middle;
    }

    .dataframe tbody tr th {
        vertical-align: top;
    }

    .dataframe thead th {
        text-align: right;
    }
</style>
<table border="1" class="dataframe">
<thead>
<tr style="text-align: right;">
<th></th>
<th>Annual Income</th>
<th>Spending Score</th>
<th>Jumlah Pelanggan</th>
</tr>
<tr>
<th>Cluster_Label</th>
<th></th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>
<tr>
<th>0</th>
<td>155216.363540</td>
<td>75.109115</td>
<td>3785</td>
</tr>
<tr>
<th>1</th>
<td>65194.690378</td>
<td>25.788929</td>
<td>3866</td>
</tr>
<tr>
<th>2</th>
<td>64904.238964</td>
<td>75.510970</td>
<td>3783</td>
</tr>
<tr>
<th>3</th>
<td>156308.244444</td>
<td>25.576132</td>
<td>3645</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedText jp-OutputArea-output" data-mime-type="text/plain" tabindex="0">
<pre>
Hasil Akhir dengan Nama Segmen Bisnis:
</pre>
</div>
</div>
<div class="jp-OutputArea-child">
<div class="jp-OutputPrompt jp-OutputArea-prompt"></div>
<div class="jp-RenderedHTMLCommon jp-RenderedHTML jp-OutputArea-output" data-mime-type="text/html" tabindex="0">
<div>
<style scoped="">
    .dataframe tbody tr th:only-of-type {
        vertical-align: middle;
    }

    .dataframe tbody tr th {
        vertical-align: top;
    }

    .dataframe thead th {
        text-align: right;
    }
</style>
<table border="1" class="dataframe">
<thead>
<tr style="text-align: right;">
<th></th>
<th>Age</th>
<th>Annual Income</th>
<th>Spending Score</th>
<th>Nama_Segmen</th>
</tr>
</thead>
<tbody>
<tr>
<th>0</th>
<td>30</td>
<td>151479</td>
<td>89</td>
<td>Sultan/Royal</td>
</tr>
<tr>
<th>1</th>
<td>58</td>
<td>185088</td>
<td>95</td>
<td>Sultan/Royal</td>
</tr>
<tr>
<th>2</th>
<td>62</td>
<td>70912</td>
<td>76</td>
<td>Target Utama</td>
</tr>
<tr>
<th>3</th>
<td>23</td>
<td>55460</td>
<td>57</td>
<td>Target Utama</td>
</tr>
<tr>
<th>4</th>
<td>24</td>
<td>153752</td>
<td>76</td>
<td>Sultan/Royal</td>
</tr>
<tr>
<th>...</th>
<td>...</td>
<td>...</td>
<td>...</td>
<td>...</td>
</tr>
<tr>
<th>15074</th>
<td>29</td>
<td>97723</td>
<td>30</td>
<td>Hemat</td>
</tr>
<tr>
<th>15075</th>
<td>22</td>
<td>73361</td>
<td>74</td>
<td>Target Utama</td>
</tr>
<tr>
<th>15076</th>
<td>18</td>
<td>112337</td>
<td>48</td>
<td>Penabung</td>
</tr>
<tr>
<th>15077</th>
<td>26</td>
<td>94312</td>
<td>5</td>
<td>Hemat</td>
</tr>
<tr>
<th>15078</th>
<td>19</td>
<td>78045</td>
<td>2</td>
<td>Hemat</td>
</tr>
</tbody>
</table>
<p>15079 rows × 4 columns</p>
</div>
</div>
</div>
</div>
</div>
</div>
</main>
</body>
</html>
