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
}) => {
  return (
    <FormControl component="fieldset">
      <Controller
        // rules={{
        //   required: "Required",
        // }}
        render={({
          field: { onChange, onBlur, name, ref },
          fieldState: { invalid, isTouched, isDirty, error },
          formState,
        }) => (
          <RadioGroup
            row
            aria-label={question}
            name={name}
            id={question}
            onChange={onChange}
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
    console.log(this.state);
  };

  render() {
    const { question, items, assess, questionId } = this.props;

    const { classes } = this.props;

    return (
      <Card className={classes.root}>
        <CardContent>
          <Typography
            className={classes.title}
            color="textSecondary"
            gutterBottom
          >
            {question}
          </Typography>
          <RadioButtonTesting
            handleOnchanges={this.handleChange}
            assess={assess}
            data={items}
            value={"test"}
            label={"test"}
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
