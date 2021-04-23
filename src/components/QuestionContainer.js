import React, { Component } from "react";
import {
  FormControl,
  Card,
  CardContent,
  RadioGroup,
  FormControlLabel,
  Radio,
  Typography,
} from "@material-ui/core";
import { withStyles } from "@material-ui/core/styles";
import { Controller } from "react-hook-form";
// import classes from "*.module.css";

const useStyles = () => ({
  root: {
    minWidth: 275,
    marginTop: 20,
  },
  bullet: {
    display: "inline-block",
    margin: "0 2px",
    transform: "scale(0.8)",
  },
  radiogroup: {
    marginTop: 20,
  },
  title: {
    fontSize: 24,
  },
});

const RadioButtonTesting = ({
  question,
  data,
  // handleOnchanges,
  isSubmitting,
  assess,
  questionId,
  classes,
}) => {
  // const { classes } = this.props;
  return (
    <FormControl component="fieldset">
      <Controller
        rules={{ required: true }}
        render={({ field, fieldState: { error } }) => (
          <div {...field}>
            <RadioGroup
              className={classes.radiogroup}
              row
              aria-label={question}
              id={question}
              control={assess}
              // defaultValue="top"
            >
              {data.map(({ value, disabled, label }, i) => {
                return (
                  <FormControlLabel
                    key={value + i}
                    value={value}
                    disabled={disabled || isSubmitting}
                    control={
                      <Radio
                        color="primary"
                        disabled={disabled || isSubmitting}
                      />
                    }
                    label={label}
                    //    labelPlacement="bottom"
                  />
                );
              })}
            </RadioGroup>
            {error && (
              <Typography color="error" component="p">
                ไม่สามารถเว้นว่างได้
              </Typography>
            )}
          </div>
        )}
        name={questionId.toString()}
        control={assess}
      />
    </FormControl>
  );
};

class QuestionContainer extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [],
    };
    this.handleChange = this.handleChange.bind(this);
  }
  handleChange = (event) => {
    this.setState({ [event.target.name]: event.target.value });
  };

  render() {
    const { question, items, assess, questionId, classes } = this.props;

    // const { classes } = this.props;

    return (
      <Card className={classes.root}>
        <CardContent>
          <Typography className={classes.title} gutterBottom>
            {question}
          </Typography>
          <RadioButtonTesting
            // m={20}
            // handleOnchanges={this.handleChange}
            assess={assess}
            classes={classes}
            data={items}
            // value={"test"}
            // label={"test"}
            question={question}
            questionId={questionId}
            isSubmitting={false}
          />
        </CardContent>
      </Card>
    );
  }
}

export default withStyles(useStyles)(QuestionContainer);
