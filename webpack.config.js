const path = require("path");
const webpack = require("webpack");
const ExtractTextPlugin = require("extract-text-webpack-plugin");

// Configuration for the ExtractTextPlugin.
const extractConfig = {
  use: [
    { loader: "raw-loader" },
    {
      loader: "postcss-loader",
      options: {
        plugins: [require("autoprefixer")]
      }
    },
    {
      loader: "sass-loader",
      query: {
        outputStyle:
          "production" === process.env.NODE_ENV ? "compressed" : "nested"
      }
    }
  ]
};

module.exports = {
  entry: {
    "./Admin/js/gutenberg": "./Admin/js/block.js"
    // './assets/js/frontend.blocks' : './blocks/frontend.js',
  },
  output: {
    path: path.resolve(__dirname),
    filename: "[name].js"
  },
  devtool: "cheap-eval-source-map",
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@wordpress/default"],
            plugins: [
              [
                "@babel/transform-react-jsx",
                { pragma: "wp.element.createElement" }
              ]
            ]
          }
        }
      }
    ]
  }
};